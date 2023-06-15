<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use App\Models\Product;
use App\Models\ProductCategorias;
use App\Models\ProductMovimento;
use App\Models\User;
use App\Services\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $model;
    protected $tools;

    function __construct()
    {
        $this->model = new Product();
        $this->tools = new Tools();
    }

    private function counts(User $user)
    {
        $product_total = Product::where('company_id', $user->company_id)->count();
        $categories_total = ProductCategorias::where('company_id', $user->company_id)->count();

        return [
            'product_total' => $product_total,
            'categories_total' => $categories_total,
            'files_total' => 0,
        ];
    }


    public function listing(Request $request)
    {
        $params = $request->all();
        $resp = $this->model->with('categoria')->where('produtos.company_id', $request->user()->company_id);

        if (isset($params['report'])) {
            
            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d') . ' 00:00';
            $data_fim = isset($params['data_fim']) && !empty($params['data_fim']) ? $params['data_fim'] . ' 23:59' : null;
                        
            if (isset($params['tipo_tempo'])){
                if ($data_ini && $data_fim == null) {
                    $resp->where('produtos.created_at', 'like', "%{$data_ini}%");
                } elseif ($data_ini && $data_fim) {
                    $resp->whereBetween('produtos.created_at', [$data_ini, $data_fim]);
                }
            }

            if (isset($params['tipo'])) {

                switch ($params['tipo']) {
                    case 1:
                        $resp->where('estoque_atual', '>', 0);
                        break;
                    case 2:
                        $resp->where('estoque_atual', '=', 0);
                        break;
                    case 3:
                        $resp->select('produtos.*', DB::raw('SUM(vendas_itens.quantidade) AS qtd_vende'))
                        ->join('vendas_itens', 'vendas_itens.produto_id', '=', 'produtos.uuid')
                        ->join('vendas', 'vendas.uuid', '=', 'vendas_itens.venda_id')
                        ->where('vendas.status_id', 10)
                        ->groupBy('vendas_itens.produto_id')
                        ->orderBy('qtd_vende', 'desc');
                        break;
                    case 4:
                        $resp->select('produtos.*', DB::raw('SUM(vendas_itens.quantidade) AS qtd_vende'))
                        ->join('vendas_itens', 'vendas_itens.produto_id', '=', 'produtos.uuid')
                        ->join('vendas', 'vendas.uuid', '=', 'vendas_itens.venda_id')
                        ->where('vendas.status_id', 10)
                        ->groupBy('vendas_itens.produto_id')
                        ->orderBy('qtd_vende', 'asc');
                        break;
                    case 5:
                        $resp->select('produtos.*', DB::raw('SUM(vendas_itens.valor_unitario - vendas_itens.valor_custo) AS lucro_vende'))
                        ->join('vendas_itens', 'vendas_itens.produto_id', '=', 'produtos.uuid')
                        ->join('vendas', 'vendas.uuid', '=', 'vendas_itens.venda_id')
                        ->where('vendas.status_id', 10)
                        ->groupBy('vendas_itens.produto_id')
                        ->orderBy('lucro_vende', 'desc');
                        break;
                    case 6:
                        $resp->select('produtos.*', DB::raw('SUM(vendas_itens.valor_unitario - vendas_itens.valor_custo) AS lucro_vende'))
                        ->join('vendas_itens', 'vendas_itens.produto_id', '=', 'produtos.uuid')
                        ->join('vendas', 'vendas.uuid', '=', 'vendas_itens.venda_id')
                        ->where('vendas.status_id', 10)
                        ->groupBy('vendas_itens.produto_id')
                        ->orderBy('lucro_vende', 'asc');
                        break;
                }
            }
            
            if (isset($params['status'])) {
                $resp->where('status', $params['status']);
            }
            
            $result = $resp->get();

            return response()->json($result);

        }

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('codigo_barras', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('referencia', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('nome', 'like', '%' . $params['termo'] . '%');
            });
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
        
        if (isset($dados['foto'])) {
            
            foreach ($dados['foto'] as $foto) {
                $ext = $this->tools->getExtensionFileName($foto);
                $pathLogo = "{$request->user()->company_id}/logos";
                $path = $this->tools->parse_file($foto, $pathLogo, $ext);
                Galeria::create([
                    'produto_id' => $dados['uuid'],
                    'foto' => $path
                ]);
            }
            unset($dados['foto']);
        } 

        $resp = $this->model->create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar produto'], 500);
        }

        if($dados['tipo'] == 1) {
            //gera movimento
            ProductMovimento::create([
                'tipo' => 1, //entrada
                'produto_id' => $resp->uuid,
                'user_id' => $request->user()->uuid,
                'quantidade' => $dados['estoque_atual'],
                'valor_custo' => isset($dados['valor_custo']) ? $dados['valor_custo'] : 0
            ]);
            return response()->json(['message' => 'Produto cadastrado.'], 201);
        }

        return response()->json(['message' => 'Serviço cadastrado.'], 201);
    }


    public function getById($uuid)
    {
        $resp = $this->model->with(['categoria', 'movimentos', 'fotos'])->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Produto não encontrado'], 500);
        }

        return response()->json($resp);
    }


    public function checkFoto(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = $this->model->where('uuid', $uuid)->first();
        
        if (empty($resp)) {
            return response()->json(['message' => 'Produto não encontrado'], 500);
        }
        
        $check = Galeria::where('id', $dados['id_galeria'])->first();
        
        if (empty($check)) {
            return response()->json(['message' => 'Foto não encontrada'], 500);
        }
        
        $resp->foto = $check->id;

        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar produto'], 500);
        }

        return response()->json(['message' => 'produto atualizado.'], 201);
    }

    public function update(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = $this->model->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Produto não encontrado'], 500);
        }
        
        if (isset($dados['foto']) && !filter_var($dados['foto'], FILTER_VALIDATE_URL)) {
            foreach ($dados['foto'] as $foto) {
                $ext = $this->tools->getExtensionFileName($foto);
                $pathLogo = "{$request->user()->company_id}/logos";
                $path = $this->tools->parse_file($foto, $pathLogo, $ext);
                Galeria::create([
                    'produto_id' => $resp->uuid,
                    'foto' => $path
                ]);
            }
            unset($dados['foto']);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar produto'], 500);
        }

        return response()->json(['message' => 'produto atualizado.'], 201);
    }


    public function delete($uuid)
    {
        $resp = $this->model->where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar produto'], 500);
        }

        return response()->json(['message' => 'Registro deletado.'], 201);
    }


    //estoque
    public function movimentaEstoque(Request $request)
    {
        $params = $request->all();
        $produto = $this->model->where('uuid', $params['produto_id'])->first();
        if (empty($produto)) {
            return response()->json(['message' => 'Produto não encontrado'], 500);
        }

        $params['user_id'] = $request->user()->uuid;
        $movimento = ProductMovimento::create($params);
        if (!$movimento->save()) {
            return response()->json(['message' => 'Não foi possível gerar a movimentação'], 500);
        }

        if ($movimento->tipo == 1) {
            $produto->estoque_atual += $movimento->quantidade;
        } else {
            $produto->estoque_atual -= $movimento->quantidade;
        }
        $produto->save();

        return response()->json(['message' => 'Movimentação feita com sucesso', 'result' => $movimento], 201);
    }
    public function movimentaEstoqueRemove($id)
    {
        $movimento = ProductMovimento::find($id);
        if (empty($movimento)) {
            return response()->json(['message' => 'Movimentação não encontrada'], 500);
        }

        $produto = Product::where('uuid', $movimento->produto_id)->first();

        if ($movimento->tipo == 1) { //entrada
            $produto->estoque_atual -= $movimento->quantidade;
        } else {
            $produto->estoque_atual += $movimento->quantidade;
        }

        $produto->save();

        if (!$movimento->delete()) {
            return response()->json(['message' => 'Não foi possível remover a movimentação'], 500);
        }

        return response()->json(['message' => 'Remoção feita com sucesso'], 201);
    }


    //categorias
    public function listingCategories(Request $request)
    {
        $params = $request->all();
        $resp = ProductCategorias::where('company_id', $request->user()->company_id);
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
        $resp = ProductCategorias::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria cadastrada.'], 201);
    }
    public function getCategoryById($uuid)
    {
        $resp = ProductCategorias::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrada'], 500);
        }

        return response()->json($resp);
    }

    public function updateCategory(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = ProductCategorias::where('uuid', $uuid)->first();
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
        $resp = ProductCategorias::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria deletado.'], 201);
    }

    // Galeria
    public function deleteFoto($id)
    {
        $resp = Galeria::where('id', $id)->first();
        
        if (empty($resp)) {
            return response()->json(['message' => 'Pessoal não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar produto'], 500);
        }

        return response()->json(['message' => 'Registro deletado.'], 201);
    }

    //utils
    public function searchProduct(Request $request)
    {
        $params = $request->all();
        $resp = $this->model->where('company_id', $request->user()->company_id);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('codigo_barras', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('referencia', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('nome', 'like', '%' . $params['termo'] . '%');
            });
        }

        $resp = $resp->get();

        if (count($resp) > 1) {
            return response()->json(['message' => 'Mais de um produto encontrado.'], 500);
        } elseif (count($resp) == 1) {
            return response()->json($resp[0]);
        } else {
            return response()->json(['message' => 'Nenhum produto encontrado.'], 500);
        }
    }
}
