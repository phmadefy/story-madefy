<?php

namespace App\Repositories;

use App\Http\Controllers\PessoalController;
use App\Models\ClienteCategories;
use App\Models\ContaCategoria;
use App\Models\FornecedorCategories;
use App\Models\PessoalCategorias;
use App\Models\ProductCategorias;
use App\Models\ReceitaCategoria;
use App\Models\TransportadoraCategories;
use App\Repositories\Eloquent\Repository;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class CategoriasRepository
 * @package App\Repositories
 */
class CategoriasRepository extends Repository
{

    protected $relations = [];
    protected $deleteRelations = [];
    protected $hasCompany = true;
    protected $hasUuid = true;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Models\Categorias';
    }

    /**
     * @return mixed
     */
    public function relations()
    {
        return $this->relations;
    }

    /**
     * @return string
     */
    public function validator()
    {
        return 'App\Validators\CategoriasValidator';
    }

    public function index(Request $request)
    {

        $conta = ContaCategoria::selectRaw("nome, status, uuid, 'cat_contas' as tipo ")
            ->where('company_id', '=', $this->company);

        $receita = ReceitaCategoria::selectRaw("nome, status, uuid, 'cat_receitas' as tipo ")
            ->where('company_id', '=', $this->company);

        $pessoal = PessoalCategorias::selectRaw("nome, status, uuid, 'cat_pessoal' as tipo ")
            ->where('company_id', '=', $this->company);

        $fornecedores = FornecedorCategories::selectRaw("nome, status, uuid, 'cat_fornecedores' as tipo ")
            ->where('company_id', '=', $this->company);

        $produtos = ProductCategorias::selectRaw("nome, status, uuid, 'cat_produtos' as tipo ")
            ->where('company_id', '=', $this->company);

        $transp = TransportadoraCategories::selectRaw("nome, status, uuid, 'cat_transportadoras' as tipo ")
            ->where('company_id', '=', $this->company);

        return ClienteCategories::selectRaw("nome, status, uuid, 'cat_clientes' as tipo ")
            ->where('company_id', '=', $this->company)
             ->union($conta)
             ->union($receita)
             ->union($fornecedores)
             ->union($produtos)
             ->union($transp)
            ->get();
    }

    public function create(array $data)
    {
        $data['company_id'] = $this->company;

        $data['uuid'] = Str::uuid();

        switch ($data['tipo']) {
            case 'cat_clientes':
                return ClienteCategories::create($data);
                break;
            case 'cat_contas':
                return ContaCategoria::create($data);
                break;
            case 'cat_receitas':
                return ReceitaCategoria::create($data);
                break;
            case 'cat_fornecedores':
                return FornecedorCategories::create($data);
                break;
            case 'cat_pessoal':
                return PessoalCategorias::create($data);
                break;
            case 'cat_produtos':
                return ProductCategorias::create($data);
                break;
            case 'cat_transportadoras':
                return TransportadoraCategories::create($data);
                break;
            default:
                return response()->json(['message' => 'Tipo de categoria não encontrara.'], 500);
        }
    }

    public function update(array $data, $id)
    {
        $data['company_id'] = $this->company;

        $tipo = $data['tipo'];
        unset($data['tipo']);

        switch ($tipo) {
            case 'cat_clientes':
                return ClienteCategories::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_contas':
                return ContaCategoria::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_receitas':
                return ReceitaCategoria::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_fornecedores':
                return FornecedorCategories::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_pessoal':
                return PessoalCategorias::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_produtos':
                return ProductCategorias::where('uuid', '=', $id)->update($data);
                break;
            case 'cat_transportadoras':
                return TransportadoraCategories::where('uuid', '=', $id)->update($data);
                break;
            default:
                return response()->json(['message' => 'Tipo de categoria não encontrara.'], 500);
        }
    }

    public function delete($id)
    {
        if (ContaCategoria::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)
                ->delete() ||

            ReceitaCategoria::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)
                ->delete() ||

            PessoalCategorias::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)->delete() ||

            FornecedorCategories::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)->delete() ||

            ProductCategorias::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)->delete() ||

            TransportadoraCategories::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)->delete() ||

            ClienteCategories::where('uuid', '=', $id)
                ->where('company_id', '=', $this->company)->delete()) {
            return response()->json(['message' => 'Categoria deleteda.'], 201);
        }

        return response()->json(['message' => 'Tipo de categoria não encontrara.'], 500);
    }

}
