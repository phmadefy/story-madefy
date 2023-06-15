<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Emitente;
use App\Models\EmitenteConfig;
use App\Models\FiscalNFCe;
use App\Models\Product;
use App\Models\ProductMovimento;
use App\Models\Receita;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Models\VendaPagamento;
use App\Services\NotaService;
use App\Services\PrintService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendaController extends Controller
{
    protected $model;
    protected $printService;
    function __construct()
    {
        $this->model = new Venda();
        $this->printService = new PrintService();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        
        if (isset($params['report'])) {
            
            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d') . ' 00:00';
            $data_fim = isset($params['data_fim']) && !empty($params['data_fim']) ? $params['data_fim'] . ' 23:59' : null;
            
            $resp = $this->model->where('company_id', $request->user()->company_id)->orderBy('created_at', 'desc');
            
            if (isset($params['tipo_tempo'])){
                if ($data_ini && $data_fim == null) {
                    $resp->where('created_at', 'like', "%{$data_ini}%");
                } elseif ($data_ini && $data_fim) {
                    $resp->whereBetween('created_at', [$data_ini, $data_fim]);
                }
            }

            if (isset($params['tipo'])) {
                $resp->where('status_id', $params['tipo']);
            }
            
            $result = $resp->get();

            return response()->json($result);

        }

        $resp = $this->model->with(['vendedor'])->where('company_id', $request->user()->company_id)->orderBy('created_at', 'desc')
            ->paginate($params['per_page']);

        return response()->json($resp);
    }

    public function create(Request $request)
    {

        $sequencia = $this->model->where('company_id', $request->user()->company_id)->max('sequencia');

        $dados = $request->all();
        $dados['sequencia'] = ($sequencia > 0) ? $sequencia + 1 : 1;
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $dados['user_id'] = $request->user()->uuid;
        $resp = $this->model->create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao gerar nova venda'], 500);
        }

        return response()->json(['message' => 'Nova venda gerada.', 'sale' => $resp], 201);
    }

    public function getById($uuid)
    {
        $resp = $this->model->with(['vendedor', 'itens', 'nfce', 'pagamentos'])->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        if ($resp->status_id == 10) {
            $resp->dataCupom = $this->printService->printSaleCupom($resp->company, $resp, $resp->vendedor);
        }
        if (!empty($resp->nfce)) {
            $resp->dataNFCe = $this->printService->printNFCeCupom($resp->nfce);
        }


        return response()->json($resp);
    }

    public function update(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Venda não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar venda'], 500);
        }

        if ($dados['status_id'] == 0) { //canelar venda
            Caixa::where('venda_id', $resp->uuid)->delete();
            $this->processEstoqueSale($resp, 1);
        }

        return response()->json(['message' => 'Venda atualizada.', 'resp' => $this->getById($uuid)->original], 201);
    }

    public function delete($uuid)
    {
        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'venda não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar venda'], 500);
        }

        return response()->json(['message' => 'venda deletada.'], 201);
    }


    //finalizando venda
    public function finishSale(Request $request)
    {
        $params = $request->all();
        $sale = $this->model->where('uuid', $params['uuid'])->first();
        if (empty($sale)) {
            return response()->json(['message' => 'Venda não encontrada!'], 500);
        }

        if (count($params['itens']) == 0) {
            return response()->json(['message' => 'Venda não contem itens!'], 500);
        }

        if (!$this->processPaymentSale($params['payments'], $sale)) {
            return response()->json(['message' => 'Falha ao registrar os pagamentos!'], 500);
        }

        $params['status'] = "Finalizada.";
        $params['status_id'] = 10;
        $sale->fill($params);
        if (!$sale->save()) {
            VendaPagamento::where('venda_id', $sale['uuid'])->delete();
            return response()->json(['message' => 'Falha ao salvar venda!'], 500);
        }

        $this->processEstoqueSale($sale);

        return response()->json($sale);
    }

    private function processPaymentSale($payments, $sale)
    {
        foreach ($payments as $payment) {
            $payment['uuid'] = Str::uuid();
            $pay = VendaPagamento::create($payment);
            if (!$pay->save()) {
                VendaPagamento::where('venda_id', $payment['venda_id'])->delete();
                Caixa::where('venda_id', $payment['venda_id'])->delete();
                return false;
                break;
            }

            if (!isset($payment['parcelas'])) {
                $this->processCaixa($pay, $sale);
            } else {

                foreach ($payment['parcelas'] as $parcela) {
                    $conta = [
                        'company_id' => $sale->company_id,
                        'venda_id' => $sale['uuid'],
                        'cliente_id' => $sale['cliente_id'],
                        'uuid' => Str::uuid(),
                        'cliente' => $sale['cliente'],
                        'vendedor_id' => $sale['user_id'],
                        'vendedor' => $sale['vendedor'],
                        'description' => "Parcela da venda Nº: " . $sale['id'],
                        'documento' => $sale['id'] . "/" . $parcela['num'],
                        'valor' => $parcela['valor'],
                        'vencimento' => $parcela['data_vence']
                    ];

                    // if (isset($payment['status_pago']) && $payment['status_pago'] == 10) {
                    //     $this->geraCaixa($sale, $payment);
                    // } else {
                    // }

                    Receita::create($conta);
                }
            }
        }

        return true;
    }

    private function processCaixa($pay, $sale)
    {
        Caixa::create([
            'tipo' => 1,
            'description' => "Venda nº {$sale->sequencia}",
            'valor' => ($pay->valor_pago > $pay->valor_resto) ? $pay->valor_resto : $pay->valor_pago,
            'uuid' => Str::uuid(),
            'forma_id' => $pay->forma_id,
            'forma' => $pay->forma,
            'venda_id' => $pay->venda_id,
            'company_id' => $sale->company_id,
        ]);
    }
    private function processEstoqueSale(Venda $sale, $type = 2)
    {
        $itens = VendaItem::where('venda_id', $sale->uuid)->get()->toArray();
        foreach ($itens as $item) {
            if ($type == 1) {
                ProductMovimento::where('venda_id', $sale->uuid)->where('produto_id', $item['produto_id'])->delete();
                $produto = Product::where('uuid', $item['produto_id'])->first();
                if (!empty($produto)) {
                    $produto->estoque_atual += $item['quantidade'];
                    $produto->save();
                }
            } else {
                $item['tipo'] = 2;
                $movimento = ProductMovimento::create($item);
                $produto = Product::where('uuid', $item['produto_id'])->first();
                if (!empty($produto)) {
                    $produto->estoque_atual -= $item['quantidade'];
                    $produto->save();
                }
            }
        }
    }

    ///notas fiscais
    public function EmiteNFCe(Request $request, $sale_id)
    {
        $params = $request->all();
        $sale = Venda::with(['company', 'vendedor', 'itens', 'itens.product', 'nfce', 'pagamentos', 'pagamentos.pay'])->where('uuid', $sale_id)->first();
        if (empty($sale)) {
            return response()->json(['message' => 'Venda não encontrada!'], 500);
        }

        $emitente = Emitente::where('uuid', $params['uuid'])->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado!'], 500);
        }

        $config = EmitenteConfig::where('emitente_id', $emitente->uuid)->where('modelo', 65)->first();
        if (empty($config)) {
            return response()->json(['message' => 'Configurações do emitente não encontrado!'], 500);
        }
        $emitente->config = $config;

        try {
            $notaService = new NotaService($emitente, 65);

            $resp = $notaService->make($sale);

            if (isset($resp['erros'])) {
                return response()->json($resp, 500);
            }

            $resp['uuid'] = Str::uuid();
            $resp['venda_id'] = $sale->uuid;
            $resp['cliente'] = $sale->cliente;
            $resp['cnpj'] = $sale->cpf;

            $resp['subtotal'] = $sale->subtotal;
            $resp['desconto'] = $sale->desconto;
            $resp['total'] = $sale->total;

            $NFCe = FiscalNFCe::create($resp);
            if (!$NFCe->save()) {
                return response()->json(['message' => 'Falha ao gravar dados NFCe!'], 500);
            }

            if ($config->tipo_ambiente == 1) {
                $config->sequencia += 1;
            } else {
                $config->sequencia_homolog += 1;
            }
            $config->save();

            return response()->json(['message' => 'NFCe emitida com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    //itens da venda
    public function createItem(Request $request)
    {
        $dados = $request->all();
        $sale = $this->model->where("uuid", $dados['venda_id'])->first();
        if (empty($sale)) {
            return response()->json(['message' => 'Falha ao adicionar item na venda, venda não encontrada.'], 500);
        }

        $dados['uuid'] = Str::uuid();
        // $dados['company_id'] = $request->user()->company_id;
        // $dados['user_id'] = $request->user()->uuid;
        $resp = VendaItem::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao adicionar item na venda'], 500);
        }

        $this->calcTotalSale($resp->venda_id);

        return response()->json(['message' => 'Item adicionado na venda.'], 201);
    }
    public function getItemById($uuid)
    {
        $resp = VendaItem::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Item não encontrado'], 500);
        }

        return response()->json($resp);
    }
    public function updateItem(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = VendaItem::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Item não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar item'], 500);
        }

        $this->calcTotalSale($resp->venda_id);

        return response()->json(['message' => 'Item atualizado.'], 201);
    }
    public function deleteItem($uuid)
    {
        $resp = VendaItem::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Item não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao remover item'], 500);
        }

        $this->calcTotalSale($resp->venda_id);

        return response()->json(['message' => 'Item removido.'], 201);
    }


    //utilidades
    private function calcTotalSale($sale_id)
    {
        $sale = $this->model->where("uuid", $sale_id)->first();
        if (empty($sale)) {
            return response()->json(['message' => 'Falha ao adicionar item na venda, venda não encontrada.'], 500);
        }

        $itens = VendaItem::where('venda_id', $sale_id)->get();
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

        $sale->subtotal = $subtotal;
        $sale->descontos = $descontos;
        $sale->total_custo = $total_custo;
        $sale->total = $total;

        $sale->save();
    }
}
