<?php

namespace App\Http\Controllers;

use App\Models\Aliquotas;
use App\Models\Contrato;
use App\Models\ContratoItem;
use App\Models\Emitente;
use App\Models\EmitenteConfigNfs;
use App\Models\FiscalNFSe;
use App\Models\StatusContrato;
use App\Services\NFSeGoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    protected $model;
    protected $user;
    function __construct(Contrato $model, Request $request)
    {
        $this->model = $model;
        $this->user = $request->user();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        $result = $this->model->where('company_id', $this->user->company_id);

        if (isset($params['per_page'])) {
            $result = $result->paginate($params['per_page']);
        } else {
            $result = $result->get();
        }

        return response()->json($result);
    }


    public function create(Request $request)
    {

        try {
            $params = $request->all();

            $params['uuid'] = Str::uuid();
            $params['company_id'] = $this->user->company_id;
            $params['user_id'] = $this->user->uuid;
            $params['status_id'] = StatusContrato::whereCodigo('st_aberto')->first()['id'] ?? 1;

            $result = $this->model->create($params);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['message' => "Falha ao criar: {$e->getMessage()}"], 500);
        }
    }

    public function getById($id)
    {
        try {
            $result = $this->model->with(['vendedor', 'nfse'])->where('uuid', $id)->first();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => "Falha ao criar: {$e->getMessage()}"], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $resp = $this->model->where('uuid', $id)->first();
            if (empty($resp)) {
                return response()->json(['message' => "Registro não encontrado!"], 404);
            }

            $resp->fill($request->all())->save();
            if ($resp->status_id == 10) {
                $message = 'Contrato finalizado.';
            } else {
                $message = 'Contrato atualizado.';
            }

            return response()->json(['message' => $message], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Falha ao criar: {$e->getMessage()}"], 500);
        }
    }




    public function listingItens(Request $request)
    {
        $params = $request->all();
        $resp = ContratoItem::where('contrato_id', $params['contrato_id'])->orderBy('created_at', 'DESC')->get();

        return response()->json($resp);
    }

    public function createItem(Request $request)
    {
        $params = $request->all();
        try {
            $params['uuid'] = Str::uuid();
            $resp = ContratoItem::create($params);

            $this->updateValorContrato($params['contrato_id']);
            return response()->json(['message' => 'Item adicionado.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function updateValorContrato($uuid){

        $valor = ContratoItem::where('contrato_id', '=', $uuid)->sum('total') ?? 0;

        return Contrato::where('uuid', '=', $uuid)->update([
            'valor_contrato' => $valor
        ]);

    }


    public function getItemById($id)
    {
        try {
            $resp = ContratoItem::where('uuid', $id)->first();
            if (empty($resp)) {
                return response()->json(['message' => "Registro não encontrado!"], 404);
            }

            return response()->json($resp);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function updateItem(Request $request, $id)
    {
        try {
            $resp = ContratoItem::where('uuid', $id)->first();
            if (empty($resp)) {
                return response()->json(['message' => "Registro não encontrado!"], 404);
            }

            $resp->fill($request->all())->save();

            $this->updateValorContrato($request['contrato_id']);

            return response()->json(['message' => 'Item atualizado.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function deleteItem($id)
    {
        try {
            $resp = ContratoItem::where('uuid', $id)->first();
            if (empty($resp)) {
                return response()->json(['message' => "Registro não encontrado!"], 404);
            }

            $resp->delete();

            return response()->json(['message' => 'Item excluído.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $resp = Contrato::where('uuid', $id)->first();

            if (empty($resp)) {
                return response()->json(['message' => "Registro não encontrado!"], 404);
            }

            if($resp->statusContrato->codigo != 'st_aberto'){
                return response()->json(['message' => "Somente contratos em aberto podem ser deletados!"], 401);
            }

            $resp->delete();

            return response()->json(['message' => 'Item excluído.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function iniciar($uuid){
        $resp = Contrato::where('uuid','=', $uuid)->first();

        $status = StatusContrato::where('codigo', '=', 'st_iniciado')->first()['id'] ?? 2;

        $resp->status_id = $status;

        return $resp->save();
    }


    public function emiteNFSe(Request $request)
    {

        $dados = $request->all();

        $emitente = Emitente::where('uuid', '=', $dados['emitente'])->first();
        $emitente->config = EmitenteConfigNfs::where('emitente_id', $emitente->uuid)->first();

        $contrato = Contrato::where('uuid', '=', $dados['contrato'])->first();

        try {
            $nfseService = new NFSeGoService($emitente);

            $resp = $nfseService->make($contrato);

            if(isset($resp->ListaNfse)){
                $contrato->emitir_nfse = 1;
                $contrato->save();

                $serie = $emitente->config->tipo_ambiente == 1 ? $emitente->config->serie : $emitente->config->serie_homolog;

                $aliquota = Aliquotas::where('emitente_id', '=', $emitente->uuid)
                    ->where('referencia', '<=', Carbon::now()->toDateString())->orderBy('referencia', 'desc')->first()['id'] ?? null;

                FiscalNFSe::create([
                    'uuid' => Str::uuid(),
                    'emitente_id' => $emitente->uuid,
                    'pagador_id' => $contrato->cliente_id,
                    'contrato_id'=> $contrato->uuid,
                    'numero' => $resp->ListaNfse->CompNfse->Nfse->InfNfse->Numero[0],
                    'serie' => $serie,
                    'im' => $resp->ListaNfse->CompNfse->Nfse->InfNfse->DeclaracaoPrestacaoServico->Prestador->IdentificacaoPrestador->InscricaoMunicipal[0],
                    'producao' => $emitente->config->tipo_ambiente == 1,
                    'codigoVerificacao' =>  $resp->ListaNfse->CompNfse->Nfse->InfNfse->CodigoVerificacao[0],
                    'company_id' => $contrato->company_id,
                    'aliquota_id' => $aliquota,
                ]);
            }

            return response()->json($resp);
	} catch (\Exception $e) {
		Log::info($e);
            print_r($e->getMessage());
        }
    }
}
