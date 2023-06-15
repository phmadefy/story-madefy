<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use App\Services\Tools;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    protected $model;
    protected $tools;

    function __construct()
    {
        $this->model = new Company();
        $this->tools = new Tools();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        $resp = $this->model->where('uuid', '!=', $request->user()->uuid);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('razao', 'like', '%' . $params['termo'] . '%');
                    // ->orWhere('apelido', 'like', '%' . $params['termo'] . '%')
                    // ->orWhere('cpf', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->limit($params['per_page'])->get();
        }

        return response()->json(['paginate' => $resp]);
    }


    public function create(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $resp = $this->model->create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar usuário'], 500);
        }

        return response()->json(['message' => 'usuário cadastrado.'], 201);
    }


    public function getById($uuid)
    {
        $resp = $this->model->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'usuário não encontrado'], 500);
        }

        return response()->json($resp);
    }


    public function update(Request $request, $uuid)
    {
        $dados = $request->all();
        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'usuário não encontrado'], 500);
        }

        if (isset($dados['logo_full']) && strpos($dados['logo_full'], 'data:image') !== false) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $dados['logo_full'] = $this->tools->parse_file($dados['logo_full'], $pathLogo, $dados['extension']);
        } else {
            unset($dados['logo_full']);
        }
        
        if (isset($dados['logo_min']) && strpos($dados['logo_min'], 'data:image') !== false) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $dados['logo_min'] = $this->tools->parse_file($dados['logo_min'], $pathLogo, $dados['extension']);
        } else {
            unset($dados['logo_min']);
        }
        
        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar usuário'], 500);
        }

        return response()->json(['message' => 'usuário atualizado.', $dados], 201);
    }


    public function delete($uuid)
    {
        $resp = $this->model->where('id', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'usuário não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar usuário'], 500);
        }

        return response()->json(['message' => 'Registro deletado.'], 201);
    }


}
