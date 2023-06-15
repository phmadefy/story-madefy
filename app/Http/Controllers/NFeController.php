<?php

namespace App\Http\Controllers;

use App\Models\Emitente;
use App\Models\EmitenteConfig;
use App\Models\NFe;
use App\Models\NFeItens;
use App\Models\NFePagamentos;
use App\Models\NFeReferences;
use App\Services\NotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NFeController extends Controller
{
    protected $model;
    protected $user;
    function __construct(Request $request)
    {
        $this->model = new NFe();
        $this->user = $request->user();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        $resp = NFe::where('company_id', $this->user->company_id);

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->limit($params['per_page'])->get();
        }
        return response()->json($resp);
    }

    public function create(Request $request)
    {
        $dados = $request->all();
        $nota = NFe::create(['natOpe' => "Venda de mercadoria", 'uuid' => Str::uuid(), 'company_id' => $this->user->company_id]);

        if (!$nota->save()) {
            return response()->json(['message' => 'Falha ao gerar nova NFe.'], 500);
        }

        return response()->json(['message' => 'NFe gerada com sucesso.', 'dados' => $nota], 201);
    }

    public function getById($id)
    {
        $nota = NFe::with(['pagamentos', 'references'])->where('uuid', $id)->where('company_id', $this->user->company_id)->first();
        if (empty($nota)) {
            return response()->json(['message' => 'NFe não encontrada.'], 500);
        }

        if ($nota->cstatus == 100 || $nota->cstatus == 101 || $nota->cstatus == 135 || $nota->cstatus == 155) {
            $emitente = Emitente::where('company_id', $this->user->company_id)->where('uuid', $nota->emitente_id)->first();
            if (empty($emitente)) {
                return response()->json(['message' => 'Emitente não encontrado.'], 500);
            }
            $emitente->config = EmitenteConfig::where('emitente_id', $emitente->uuid)->where('modelo', 55)->first();
            if (empty($emitente->config)) {
                return response()->json(['message' => 'Configurações do Emitente não encontrado.'], 500);
            }
            $notaService = new NotaService($emitente, 55);
            $nota->linkNFe = $notaService->geraPDF($nota);
        }

        return response()->json($nota);
    }

    public function update(Request $request, $uuid)
    {
        $params = $request->all();
        $nota = NFe::where('uuid', $uuid)->where('company_id', $this->user->company_id)->first();

        if (empty($nota)) {
            return response()->json(['message' => 'NFe não encontrada.'], 500);
        }

        $nota->fill($params);
        if (!$nota->save()) {
            return response()->json(['message' => 'Falha ao atualizar NFe.'], 500);
        }

        return response()->json(['message' => 'Dados atualizados'], 201);
    }


    //itens
    public function getItensNota($id)
    {
        $itens = NFeItens::where('nota_id', $id)->get();

        return response()->json($itens);
    }
    public function createItemNota(Request $request)
    {
        $params = $request->all();
        if (isset($params['nota_id']) && !empty($params['nota_id'])) {
            $nota = NFe::where('uuid', $params['nota_id'])->where('company_id', $this->user->company_id)->first();
            if (empty($nota)) {
                return response()->json(['message' => 'NFe não encontrada.'], 404);
            }

            $params['uuid'] = Str::uuid();
            $item = NFeItens::create($params);
            if (!$item->save()) {
                return response()->json(['message' => 'Falha ao adicionar item.'], 500);
            }

            $this->calcTotalNota($params['nota_id']);

            return response()->json(['message' => 'Item adicionado.'], 201);
        } else {
            return response()->json(['message' => 'NFe não encontrada.'], 404);
        }
    }

    public function getItemNota($id_item)
    {
        $item = NFeItens::where('uuid', $id_item)->first();
        if (empty($item)) {
            return response()->json(['message' => 'Item não encontrado.'], 404);
        }

        return response()->json($item);
    }

    public function updateItemNota(Request $request, $id_item)
    {
        $params = $request->all();
        $item = NFeItens::where('nota_id', $params['nota_id'])->where('uuid', $id_item)->first();
        if (empty($item)) {
            return response()->json(['message' => 'Item não encontrado.'], 404);
        }

        $item->fill($params);
        if (!$item->save()) {
            return response()->json(['message' => 'Falha ao atualizar item.'], 500);
        }

        $this->calcTotalNota($params['nota_id']);

        return response()->json(['message' => 'Item adicionado.'], 201);
    }

    public function deleteItemNota($id_item)
    {
        $item = NFeItens::where('uuid', $id_item)->first();
        if (empty($item)) {
            return response()->json(['message' => 'Item não encontrado.'], 404);
        }

        $nota_id = $item->nota_id;

        if (!$item->delete()) {
            return response()->json(['message' => 'Falha ao remover item.'], 500);
        }

        $this->calcTotalNota($nota_id);

        return response()->json(['message' => 'Item removido.'], 201);
    }

    //pagamentos
    public function createPaymentNota(Request $request)
    {
        $params = $request->all();
        if (isset($params['nota_id']) && !empty($params['nota_id'])) {
            $nota = NFe::where('uuid', $params['nota_id'])->where('company_id', $this->user->company_id)->first();
            if (empty($nota)) {
                return response()->json(['message' => 'NFe não encontrada.'], 404);
            }

            $params['uuid'] = Str::uuid();
            $pay = NFePagamentos::create($params);
            if (!$pay->save()) {
                return response()->json(['message' => 'Falha ao adicionar pagamento.'], 500);
            }

            return response()->json(['message' => 'pagamento adicionado.', 'data' => $pay], 201);
        } else {
            return response()->json(['message' => 'NFe não encontrada.'], 404);
        }
    }
    public function deletePaymentNota($id)
    {
        $pay = NFePagamentos::where('uuid', $id)->first();
        if (empty($pay)) {
            return response()->json(['message' => 'Pagamento não encontrado.'], 404);
        }

        if (!$pay->delete()) {
            return response()->json(['message' => 'Falha ao remover pagamento.'], 500);
        }

        return response()->json(['message' => 'Pagamento removido.'], 201);
    }

    //references
    public function createReferenceNota(Request $request)
    {
        $params = $request->all();
        if (isset($params['nota_id']) && !empty($params['nota_id'])) {
            $nota = NFe::where('uuid', $params['nota_id'])->where('company_id', $this->user->company_id)->first();
            if (empty($nota)) {
                return response()->json(['message' => 'NFe não encontrada.'], 404);
            }

            $params['uuid'] = Str::uuid();
            $reference = NFeReferences::create($params);
            if (!$reference->save()) {
                return response()->json(['message' => 'Falha ao adicionar referência.'], 500);
            }

            return response()->json(['message' => 'Referência adicionada.', 'data' => $reference], 201);
        } else {
            return response()->json(['message' => 'NFe não referência.'], 404);
        }
    }
    public function deleteReferenceNota($id)
    {
        $reference = NFeReferences::where('id', $id)->first();
        if (empty($reference)) {
            return response()->json(['message' => 'Referência não encontrada.'], 404);
        }

        if (!$reference->delete()) {
            return response()->json(['message' => 'Falha ao remover referência.'], 500);
        }

        return response()->json(['message' => 'Referência removido.'], 201);
    }

    public function EmitirNFe(Request $request, $uuid)
    {
        $params = $request->all();
        $nota = NFe::with(['itens', 'itens.product', 'pagamentos', 'pagamentos.pay', 'references'])->where('uuid', $uuid)->where('company_id', $this->user->company_id)->first();
        if (empty($nota)) {
            return response()->json(['message' => 'NFe não encontrada.'], 500);
        }

        $emitente = Emitente::where('company_id', $this->user->company_id)->where('uuid', $params['emitente_id'])->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado.'], 500);
        }
        $emitente->config = EmitenteConfig::where('emitente_id', $emitente->uuid)->where('modelo', 55)->first();
        if (empty($emitente->config)) {
            return response()->json(['message' => 'Configurações do Emitente não encontrado.'], 500);
        }

        $notaService = new NotaService($emitente, 55);

        $resp = $notaService->make($nota);
        // return response($resp);
        if (isset($resp['erros'])) {
            return response()->json($resp, 500);
        }

        $nota->fill($resp);
        $nota->save();

        if ($emitente->config->tipo_ambiente == 1) {
            $emitente->config->sequencia += 1;
        } else {
            $emitente->config->sequencia_homolog += 1;
        }
        $emitente->config->save();

        return response()->json(['message' => 'NFe Autorizada!'], 201);
    }

    public function cancelarNFe(Request $request, $uuid)
    {
        $params = $request->all();
        $nota = NFe::where('uuid', $uuid)->where('company_id', $this->user->company_id)->first();
        if (empty($nota)) {
            return response()->json(['message' => 'NFe não encontrada.'], 500);
        }

        $emitente = Emitente::where('company_id', $this->user->company_id)->where('uuid', $nota->emitente_id)->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado.'], 500);
        }
        $emitente->config = EmitenteConfig::where('emitente_id', $emitente->uuid)->where('modelo', 55)->first();
        if (empty($emitente->config)) {
            return response()->json(['message' => 'Configurações do Emitente não encontrado.'], 500);
        }

        $notaService = new NotaService($emitente, 55);

        $nota->xjust = $params['xJust'];
        $resp = $notaService->cancelarNFe($nota);
        // return response($resp);
        if (isset($resp['erros'])) {
            return response()->json($resp, 500);
        }

        //salva os dados da nota
        $resp->save();

        //consulta o status da nota
        $result = $notaService->consultarChave($resp);
        //salva a consulta
        $result->save();

        return response()->json(['message' => 'NFe Cancelada!'], 201);
    }


    //utilidades
    private function calcTotalNota($nota_id)
    {
        $nota = $this->model->where("uuid", $nota_id)->first();
        if (empty($nota)) {
            return response()->json(['message' => 'Falha ao calcular total da nota, nota não encontrada.'], 500);
        }

        $itens = NFeItens::where('nota_id', $nota_id)->get();
        $subtotal = 0;
        $descontos = 0;
        $total = 0;
        $total_custo = 0;
        foreach ($itens as $item) {
            $total_custo += ($item->quantidade * $item->valor_custo);
            $subtotal += ($item->quantidade * $item->valor_unitario);
            $descontos += $item->desconto;
            $total += ($item->quantidade * $item->valor_unitario) - $item->desconto;
        }

        $nota->subtotal = $subtotal;
        $nota->desconto = $descontos;
        // $nota->total_custo = $total_custo;
        $nota->total = $total + $nota->frete;

        $nota->save();
    }
}
