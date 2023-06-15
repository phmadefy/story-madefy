<?php

namespace App\Http\Controllers;

use App\Models\Pessoal;
use App\Models\PessoalCategorias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PessoalController extends Controller
{
    protected $model;
    function __construct()
    {
        $this->model = new Pessoal();
    }

    private function counts(User $user)
    {
        $pessoal_total = Pessoal::where('company_id', $user->company_id)->count();
        $categories_total = PessoalCategorias::where('company_id', $user->company_id)->count();

        return [
            'pessoal_total' => $pessoal_total,
            'categories_total' => $categories_total,
            'files_total' => 0,
        ];
    }


    public function listing(Request $request)
    {
        $params = $request->all();
        $resp = $this->model->with('categoria')->where('company_id', $request->user()->company_id);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('nome', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('apelido', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cpf', 'like', '%' . $params['termo'] . '%');
            });
        }
        if (isset($params['categoria_id']) && !empty($params['categoria_id'])) {
            $resp = $resp->where('categoria_id', $params['categoria_id']);
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->limit($params['per_page'])->get();
        }

        $counts = $this->counts($request->user());

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }


    public function create(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $resp = $this->model->create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar pessoal'], 500);
        }

        return response()->json(['message' => 'Pessoal cadastrado.'], 201);
    }


    public function getById($uuid)
    {
        $resp = $this->model->with('categoria')->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        return response()->json($resp);
    }


    public function update(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar pessoal'], 500);
        }

        return response()->json(['message' => 'Pessoal atualizado.'], 201);
    }


    public function delete($uuid)
    {
        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar pessoal'], 500);
        }

        return response()->json(['message' => 'Registro deletado.'], 201);
    }


    //categorias
    public function listingCategories(Request $request)
    {
        $params = $request->all();
        $resp = PessoalCategorias::where('company_id', $request->user()->company_id);
        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->get();
        }

        $counts = $this->counts($request->user());

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }


    public function createCategory(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $resp = PessoalCategorias::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria cadastrada.'], 201);
    }
    public function getCategoryById($uuid)
    {
        $resp = PessoalCategorias::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrada'], 500);
        }

        return response()->json($resp);
    }


    public function updateCategory(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = PessoalCategorias::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria atualizado.'], 201);
    }


    public function deleteCategory($uuid)
    {
        $resp = PessoalCategorias::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria deletado.'], 201);
    }
}
