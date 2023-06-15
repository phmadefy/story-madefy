<?php

namespace App\Http\Controllers;

use App\Models\Emitente;
use App\Models\EmitenteConfig;
use App\Models\EmitenteConfigNfs;
use App\Models\User;
use App\Services\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmitenteController extends Controller
{
    function __construct()
    {
        $this->tools = new Tools();
    }

    public function listingEmitente(Request $request)
    {
        $params = $request->all();
        $resp = Emitente::where('company_id', $request->user()->company_id);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('razao', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('fantasia', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cnpj', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return response()->json(['paginate' => $resp]);
    }

    public function createEmitente(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $resp = Emitente::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar emitente'], 500);
        }
        EmitenteConfig::create(['modelo' => 55, 'emitente_id' => $resp->uuid, 'uuid' => Str::uuid()]);
        EmitenteConfig::create(['modelo' => 65, 'emitente_id' => $resp->uuid, 'uuid' => Str::uuid()]);

        return response()->json(['message' => 'emitente cadastrado.'], 201);
    }

    public function getEmitenteById($uuid)
    {
        $resp = Emitente::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'emitente não encontrado'], 500);
        }

        return response()->json($resp);
    }

    public function updateEmitente(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = Emitente::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'emitente não encontrado'], 500);
        }

        if (!empty($dados['password']) && !empty($dados['senha'])) {
            $dados['password'] = bcrypt($dados['password']);
        } else {
            unset($dados['password']);
        }

        if (isset($dados['logo_url']) && !filter_var($dados['logo_url'], FILTER_VALIDATE_URL)) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $dados['logo'] = $this->tools->parse_file($dados['logo_url'], $pathLogo, 'png', $resp->logo);
        }
        if (isset($dados['certificate_url']) && !filter_var($dados['certificate_url'], FILTER_VALIDATE_URL)) {
            $pathCertificate = "{$request->user()->company_id}/certificates";
            $dados['file_pfx'] = $this->tools->parse_file($dados['certificate_url'], $pathCertificate, 'pfx', $resp->file_pfx);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar emitente'], 500);
        }

        return response()->json(['message' => 'emitente atualizado.'], 201);
    }

    public function deleteEmitente($uuid)
    {
        $resp = Emitente::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'emitente não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar emitente'], 500);
        }

        return response()->json(['message' => 'emitente deletado.'], 201);
    }

    // Configurações NFe, NFCe
    public function createEmitenteConfig(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $resp = EmitenteConfig::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao salvar configurações'], 500);
        }

        return response()->json(['message' => 'configurações salvas.'], 201);
    }

    public function getEmitenteConfig(Request $request)
    {
        $params = $request->all();
        $config = EmitenteConfig::where('emitente_id', $params['emitente'])->first();

        return response()->json($config);
    }

    public function listingByConfig($config)
    {

        $user = Auth::user();
        $company = User::find($user)->company_id;


        $resp = Emitente::where('company_id', $company);

        if($config == 'nfs'){
            $resp = $resp->whereHas('configNFS', function ($q){
                $q->where('bloqueado', '=', false);
            });
        }else{
            $resp = $resp->whereHas('configNF', function ($q){
                $q->where('bloqueado', '=', false);
            });
        }


        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('razao', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('fantasia', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cnpj', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return response()->json(['paginate' => $resp]);
    }

    public function updateEmitenteConfig(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = EmitenteConfig::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'configurações não encontradas'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar configurações'], 500);
        }

        return response()->json(['message' => 'configurações atualizadas.'], 201);
    }

    // Configurações NFSe
    public function createEmitenteConfigNfs(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $resp = EmitenteConfigNfs::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao salvar configurações'], 500);
        }

        return response()->json(['message' => 'configurações salvas.'], 201);
    }

    public function getEmitenteConfigNfs(Request $request)
    {
        $params = $request->all();
        $config = EmitenteConfigNfs::where('emitente_id', $params['emitente'])->first();

        return response()->json($config);
    }

    public function updateEmitenteConfigNfs(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = EmitenteConfigNfs::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'configurações não encontradas'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar configurações'], 500);
        }

        return response()->json(['message' => 'configurações atualizadas.'], 201);
    }
}
