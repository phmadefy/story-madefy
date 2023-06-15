<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $model;
    function __construct()
    {
        $this->model = new User();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        $resp = $this->model->with('permissions')->where('company_id', $request->user()->company_id)
            ->where('uuid', '!=', $request->user()->uuid);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('nome', 'like', '%' . $params['termo'] . '%');
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
        $dados['company_id'] = $request->user()->company_id;
        $dados['password'] = bcrypt($dados['password']);
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

        if (!empty($dados['password']) && !empty($dados['senha'])) {
            $dados['password'] = bcrypt($dados['password']);
        } else {
            unset($dados['password']);
        }

        if (isset($dados['logo_url']) && !filter_var($dados['logo_url'], FILTER_VALIDATE_URL)) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $dados['logo'] = $this->tools->parse_file($dados['logo_url'], $pathLogo, 'png', $resp->logo);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar usuário'], 500);
        }

        return response()->json(['message' => 'usuário atualizado.'], 201);
    }


    public function delete($uuid)
    {
        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'usuário não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar usuário'], 500);
        }

        return response()->json(['message' => 'Registro deletado.'], 201);
    }


    ///permissions

    public function listingPermissions(Request $request)
    {
        $params = $request->all();
        $resp = UserPermission::where('company_id', $request->user()->company_id);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('description', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->get();
        }

        return response()->json(['paginate' => $resp]);
    }


    public function createPermission(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $resp = UserPermission::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar permissão'], 500);
        }

        return response()->json(['message' => 'permissão cadastrado.'], 201);
    }


    public function getPermissionById($uuid)
    {
        $resp = UserPermission::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'permissão não encontrado'], 500);
        }

        return response()->json($resp);
    }


    public function updatePermission(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = UserPermission::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'permissão não encontrado'], 500);
        }

        if (!empty($dados['password']) && !empty($dados['senha'])) {
            $dados['password'] = bcrypt($dados['password']);
        } else {
            unset($dados['password']);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar permissão'], 500);
        }

        return response()->json(['message' => 'permissão atualizado.'], 201);
    }


    public function deletePermission($uuid)
    {
        $resp = UserPermission::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'permissão não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar permissão'], 500);
        }

        return response()->json(['message' => 'Permissão deletada.'], 201);
    }

}
