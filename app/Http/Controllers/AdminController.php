<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected $model;
    function __construct()
    {
        $this->model = new Company();
    }

    public function listing(Request $request)
    {
        $company = $this->model->all();

        return response()->json($company);
    }

    public function create(Request $request)
    {
        $dados = $request->all();

        $dados['uuid'] = Str::uuid();

        $company = $this->model->create($dados);
        if (!$company->save()) {
            return response()->json(['message' => 'falha ao criar empresa'], 500);
        }

        return response()->json($company);
    }

    public function getById($uuid)
    {
        $company = $this->model->where('uuid', $uuid)->first();
        if (empty($company)) {
            return response()->json(['message' => 'Empresa não encontrada'], 500);
        }

        return response()->json($company);
    }

    public function update(Request $request, $uuid)
    {
        $dados = $request->all();
        $company = $this->model->where('uuid', $uuid)->first();
        if (empty($company)) {
            return response()->json(['message' => 'Empresa não encontrada'], 500);
        }

        $company->fill($dados);
        if (!$company->save()) {
            return response()->json(['message' => 'falha ao atualizar empresa'], 500);
        }

        return response()->json($company);
    }

    public function delete($uuid)
    {
        $company = $this->model->where('uuid', $uuid)->first();
        if (!$company->delete()) {
            return response()->json(['message' => 'Falha ao deletar empresa'], 500);
        }

        return response()->json(['message' => 'Registro deletado'], 201);
    }



    public function getUsers(Request $request)
    {
        $params = $request->all();
        $query = User::with('permissions')->where('company_id', $params['company_id']);

        $query = $query->get();

        return response()->json($query);
    }

    public function getByIdUser($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (empty($user)) {
            return response()->json(['message' => 'Usuário não encontrado'], 500);
        }
        return $user;
    }

    public function createUser(Request $request)
    {
        $params = $request->all();
        $verifica = $this->checkEmail($params['email']);

        if (count($verifica) > 0) {
            return response()->json(['erro' => "Já existe um cadastro com esse EMAIL!"]);
        }

        $params['uuid'] = Str::uuid();
        $params['password'] = bcrypt($params['password']);

        $registro = User::create($params);
        if (!$registro->save()) {
            return response()->json(['message' => "Falha ao cadastrar usuário!"], 500);
        }

        $listPermissions = UserPermission::where('company_id', $params['company_id'])->get();
        if (count($listPermissions) <= 0) {
            $permissions = [
                'description' => 'Administrador',
                'create_user' => 1, 'update_user' => 1, 'delete_user' => 1,
                'create_permission' => 1, 'update_permission' => 1, 'delete_permission' => 1,
                'create_pessoal' => 1, 'update_pessoal' => 1, 'delete_pessoal' => 1,
                'create_product' => 1, 'update_product' => 1, 'delete_product' => 1,
                'create_emitente' => 1, 'update_emitente' => 1, 'delete_emitente' => 1,
                'create_payments' => 1, 'update_payments' => 1, 'delete_payments' => 1,
                'create_sale' => 1, 'update_sale' => 1, 'pay_sale' => 1, 'desconto_sale' => 1, 'delete_sale' => 1,
                'create_monitor' => 1, 'update_monitor' => 1, 'delete_monitor' => 1,
                'create_nfe' => 1, 'update_nfe' => 1, 'delete_nfe' => 1,
                'create_caixa' => 1, 'update_caixa' => 1, 'delete_caixa' => 1,
                'create_contas' => 1, 'update_contas' => 1, 'pay_contas' => 1, 'delete_contas' => 1,
                'create_receitas' => 1, 'update_receitas' => 1, 'pay_receitas' => 1, 'delete_receitas' => 1,
                'uuid' => Str::uuid(), 'company_id' => $params['company_id'],
            ];

            $result = UserPermission::create($permissions);
            $result->save();

            $registro->permission_id = $result->uuid;
            $registro->save();
        } else {
            $registro->permission_id = $listPermissions[0]->uuid;
            $registro->save();
        }

        return response()->json(['message' => 'Usuário cadastrado'], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $params = $request->all();
        $verifica = $this->checkEmail($params['email'], $id);

        if (count($verifica) > 0) {
            return response()->json(['erro' => "Já existe um cadastro com esse EMAIL!"]);
        }

        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = bcrypt($params['password']);
        }

        $registro = User::where('uuid', $id)->first();
        if (empty($registro)) {
            return response()->json(['message' => 'Usuário não encontrado'], 500);
        }

        $registro->fill($params);

        if (!$registro->save()) {
            return response()->json(['message' => 'Usuário não atualizado'], 500);
        }

        return response()->json(['message' => 'Usuário atualizado'], 201);
    }

    public function deleteUser($id)
    {
        $registro = User::where('uuid', $id)->first();
        if (empty($registro)) {
            return response()->json(['message' => 'Usuário não encontrado'], 500);
        }

        if (!$registro->delete()) {
            return response()->json(['message' => 'Usuário não deletado'], 500);
        }

        return response()->json(['message' => 'Usuário deletado'], 201);
    }

    private function verficaCNPJ($cnpj, $id = 0)
    {
        $query = $this->model->where('cnpj', $cnpj);

        if ($id > 0) {
            $query = $query->where('id', '!=', $id);
        }

        $query = $query->get();

        return $query;
    }

    private function checkEmail($email, $id = null)
    {
        $query = User::where('email', $email);

        if ($id != null) {
            $query = $query->where('uuid', '!=', $id);
        }

        $query = $query->get();

        return $query;
    }
}
