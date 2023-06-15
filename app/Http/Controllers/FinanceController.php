<?php

namespace App\Http\Controllers;

use App\Models\Boletos;
use App\Models\Caixa;
use App\Models\CfgBoletos;
use App\Models\Cliente;
use App\Models\Conta;
use App\Models\ContaCategoria;
use App\Models\Contrato;
use App\Models\Emitente;
use App\Models\FormaPagamento;
use App\Models\Receita;
use App\Models\ReceitaCategoria;
use App\Models\User;
use App\Services\BoletoBBService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Exception\Exception;

class FinanceController extends Controller
{
    protected $currentUser;
    function __construct(Request $request)
    {
        $this->currentUser = $request->user();
    }

    //Formas de pagamento init
    public function listingForma(Request $request)
    {
        $params = $request->all();
        $resp = FormaPagamento::where('company_id', $request->user()->company_id);

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('nome', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('apelido', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cpf', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page']) && !empty($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return response()->json(['paginate' => $resp]);
    }
    public function createForma(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $resp = FormaPagamento::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao gerar nova forma de pagamento'], 500);
        }

        return response()->json(['message' => 'Nova forma de pagamento gerada.'], 201);
    }
    public function getFormaById($uuid)
    {
        $resp = FormaPagamento::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'forma de pagamento não encontrado'], 500);
        }

        return response()->json($resp);
    }
    public function updateForma(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = FormaPagamento::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'forma de pagamento não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar forma de pagamento'], 500);
        }

        return response()->json(['message' => 'forma de pagamento atualizada.'], 201);
    }
    public function deleteForma($uuid)
    {
        $resp = FormaPagamento::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'forma de pagamento não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar forma de pagamento'], 500);
        }

        return response()->json(['message' => 'forma de pagamento deletado.'], 201);
    }

    //Caixa init
    public function listingCaixa(Request $request)
    {
        $params = $request->all();

        if (isset($params['report'])) {

            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d') . ' 00:00';
            $data_fim = isset($params['data_fim']) && !empty($params['data_fim']) ? $params['data_fim'] . ' 23:59' : null;


            $result = Caixa::where('company_id', $request->user()->company_id)->groupBy('tipo');

            if (isset($params['tipo_tempo'])){
                if ($data_ini && $data_fim == null) {
                    $result->where('created_at', 'like', "%{$data_ini}%");
                } elseif ($data_ini && $data_fim) {
                    $result->whereBetween('created_at', [$data_ini, $data_fim]);
                }
            }

            if (isset($params['tipo'])) {
                $result->where('tipo', $params['tipo']);
            }

            $result = $result->get();

            return response()->json($result);

        } else {

            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d');


            $resp = Caixa::where('company_id', $request->user()->company_id)->where('created_at', 'like', "%{$data_ini}%")->get();

            $result = Caixa::select(DB::raw('SUM(valor) as total, tipo'))
                ->where('company_id', $request->user()->company_id)
                ->where('created_at', 'like', "%{$data_ini}%")
                ->groupBy('tipo');

            $result = $result->get();

            return response()->json([$resp, $result]);
        }
    }

    public function createCaixa(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $request->user()->company_id;
        $dados['user_id'] = $request->user()->uuid;
        $resp = Caixa::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao gerar movimento do caixa'], 500);
        }

        return response()->json(['message' => 'movimento do caixa gerado.'], 201);
    }
    public function getCaixaById($uuid)
    {
        $resp = Caixa::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'movimento do caixa não encontrado'], 500);
        }

        return response()->json($resp);
    }
    public function updateCaixa(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = Caixa::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'movimentação não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar movimentação'], 500);
        }

        return response()->json(['message' => 'movimentação atualizada.'], 201);
    }
    public function deleteCaixa($uuid)
    {
        $resp = Caixa::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'movimento do caixa não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar movimento do caixa'], 500);
        }

        return response()->json(['message' => 'movimento do caixa deletado.'], 201);
    }


    //receitas
    private function countsReceitas()
    {
        $total = Receita::where('company_id', $this->currentUser->company_id)->count();
        $categories_total = ReceitaCategoria::where('company_id', $this->currentUser->company_id)->count();

        return [
            'total' => $total,
            'categories_total' => $categories_total,
        ];
    }

    public function listingReceita(Request $request)
    {
        $params = $request->all();
        $resp = Receita::with('categoria')->where('company_id', $this->currentUser->company_id);

        if (isset($params['report'])) {

            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d') . ' 00:00';
            $data_fim = isset($params['data_fim']) && !empty($params['data_fim']) ? $params['data_fim'] . ' 23:59' : null;

            if (isset($params['tipo_tempo'])){
                if ($data_ini && $data_fim == null) {
                    $resp->where('created_at', 'like', "%{$data_ini}%");
                } elseif ($data_ini && $data_fim) {
                    $resp->whereBetween('created_at', [$data_ini, $data_fim]);
                }
            }

            if (isset($params['tipo'])) {
                $resp->where('situacao', $params['tipo']);
            }

            $resp = $resp->get();

            return response()->json($resp);
        }

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('vendedor', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cliente', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('venda', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('description', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->limit($params['per_page'])->get();
        }

        $counts = $this->countsReceitas();

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }

    public function createReceita(Request $request)
    {
        $params = $request->all();

        if (isset($params['parcelas']) && $params['parcelas'] > 0) {
            $currentData = $params['vencimento'];

            $dia = date('d', strtotime($currentData));
            $mes = date('m', strtotime($currentData));
            $ano = date('Y', strtotime($currentData));

            for ($i = 0; $i < $params['parcelas']; $i++) {

                $params['uuid'] = Str::uuid();
                $params['company_id'] = $this->currentUser->company_id;
                $params['vendedor_id'] = $this->currentUser->uuid;
                $params['vendedor'] = $this->currentUser->nome;
                $conta = Receita::create($params);
                $conta->documento = str_pad($conta->id, 7, "0", STR_PAD_LEFT) . "/" . $params['parcelas'];
                $conta->save();

                $mes = $mes + 1;
                if ($mes > 12) {
                    $mes = 1;
                    // ++$ano;
                    $ano = $ano + 1;
                }

                $diap = $dia;

                if ($mes == 2 && $dia > 28) {
                    $diap = 28;
                }
                if ($mes == 4 && $dia > 30 || $mes == 6 && $dia > 30 || $mes == 9 && $dia > 30 || $mes == 11 && $dia > 30) {
                    $diap = 30;
                }

                $newDate = date("Y-m-d", mktime(0, 0, 0, $mes, $diap, $ano));

                $params['vencimento'] = $newDate;
            }
        } else {
            $params['uuid'] = Str::uuid();
            $params['company_id'] = $this->currentUser->company_id;
            $params['vendedor_id'] = $this->currentUser->uuid;
            $params['vendedor'] = $this->currentUser->nome;
            $conta = Receita::create($params);
            $conta->documento = str_pad($conta->id, 7, "0", STR_PAD_LEFT) . "/1";
            if (!$conta->save()) {
                return response()->json(['message' => 'Falha ao cadastrar conta'], 500);
            }
        }

        return response()->json(['message' => 'conta cadastrada.'], 201);
    }

    public function paymentReceita(Request $request)
    {
        $params = $request->all();

        $payments = $params['payments'];
        $_dados = $params['dados'];
        $contas = $params['contas'];

        foreach ($contas as $conta) {
            // print_r($conta);
            $dados = Receita::where('uuid', $conta['uuid'])->first();
            // if (empty($dados)) {
            //     continue;
            // }
            $dados->fill($conta);

            $dados->valor_pago = $conta['valor_pago'];
            $dados->situacao = 10;
            $dados->data_pago = $_dados['data_pago'];

            $dados->save();
        }

        $this->geraCaixa($payments, $_dados);
    }
    private function geraCaixa($payments, $dados, $type = 1)
    {
        foreach ($payments as $payment) {
            // print_r($payment);
            $caixa = new Caixa();
            $caixa->uuid = Str::uuid();
            $caixa->company_id = $this->currentUser->company_id;
            $caixa->forma_id = $payment['id'];
            $caixa->forma = $payment['forma'];
            // $caixa->receita_id = $payment['id'];
            $caixa->tipo = $type;
            $caixa->description = "Ref. " . $dados['descricao'] . " - " . $payment['forma'];
            $caixa->valor = ($payment['resto'] > $payment['valor']) ? $payment['valor'] : $payment['resto'];
            $caixa->user_id = $this->currentUser->uuid;
            $caixa->save();
        }
    }

    public function getReceitaById($uuid)
    {
        $resp = Receita::with('categoria')->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'receita não encontrado'], 500);
        }

        return response()->json($resp);
    }

    public function updateReceita(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = Receita::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'receita não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar receita'], 500);
        }

        return response()->json(['message' => 'receita atualizado.'], 201);
    }

    public function deleteReceita($uuid)
    {
        $resp = Receita::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'receita não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar receita'], 500);
        }

        return response()->json(['message' => 'receita deletada.'], 201);
    }

    //categoria receitas
    public function listingReceitaCategories(Request $request)
    {
        $params = $request->all();
        $resp = ReceitaCategoria::where('company_id', $this->currentUser->company_id);
        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->get();
        }

        $counts = $this->countsReceitas();

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }

    public function createReceitaCategory(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $this->currentUser->company_id;
        $resp = ReceitaCategoria::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria cadastrada.'], 201);
    }

    public function getReceitaCategoryById($uuid)
    {
        $resp = ReceitaCategoria::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrada'], 500);
        }

        return response()->json($resp);
    }

    public function updateReceitaCategory(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = ReceitaCategoria::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria atualizado.'], 201);
    }

    public function deleteReceitaCategory($uuid)
    {
        $resp = ReceitaCategoria::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria deletada.'], 201);
    }


    //contas
    private function countsContas()
    {
        $total = Conta::where('company_id', $this->currentUser->company_id)->count();
        $categories_total = ContaCategoria::where('company_id', $this->currentUser->company_id)->count();

        return [
            'total' => $total,
            'categories_total' => $categories_total,
        ];
    }

    public function listingConta(Request $request)
    {
        $params = $request->all();

        $resp = Conta::with('categoria')->where('company_id', $this->currentUser->company_id);

        if (isset($params['report'])) {

            $data_ini = isset($params['data_ini']) && !empty($params['data_ini']) ? $params['data_ini'] : date('Y-m-d') . ' 00:00';
            $data_fim = isset($params['data_fim']) && !empty($params['data_fim']) ? $params['data_fim'] . ' 23:59' : null;

            if (isset($params['tipo_tempo'])){
                if ($data_ini && $data_fim == null) {
                    $resp->where('created_at', 'like', "%{$data_ini}%");
                } elseif ($data_ini && $data_fim) {
                    $resp->whereBetween('created_at', [$data_ini, $data_fim]);
                }
            }

            if (isset($params['tipo'])) {
                $resp->where('situacao', $params['tipo']);
            }

            $resp = $resp->get();

            return response()->json($resp);
        }

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('vendedor', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cliente', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('venda', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('description', 'like', '%' . $params['termo'] . '%');
            });
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->limit($params['per_page'])->get();
        }

        $counts = $this->countsContas();

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }

    public function createConta(Request $request)
    {
        $params = $request->all();

        if (isset($params['parcelas']) && $params['parcelas'] > 0) {
            $currentData = $params['vencimento'];

            $dia = date('d', strtotime($currentData));
            $mes = date('m', strtotime($currentData));
            $ano = date('Y', strtotime($currentData));

            for ($i = 0; $i < $params['parcelas']; $i++) {

                $params['uuid'] = Str::uuid();
                $params['company_id'] = $this->currentUser->company_id;
                $params['vendedor_id'] = $this->currentUser->uuid;
                $params['vendedor'] = $this->currentUser->nome;
                $conta = Conta::create($params);
                $conta->documento = str_pad($conta->id, 7, "0", STR_PAD_LEFT) . "/" . $params['parcelas'];
                $conta->save();

                $mes = $mes + 1;
                if ($mes > 12) {
                    $mes = 1;
                    // ++$ano;
                    $ano = $ano + 1;
                }

                $diap = $dia;

                if ($mes == 2 && $dia > 28) {
                    $diap = 28;
                }
                if ($mes == 4 && $dia > 30 || $mes == 6 && $dia > 30 || $mes == 9 && $dia > 30 || $mes == 11 && $dia > 30) {
                    $diap = 30;
                }

                $newDate = date("Y-m-d", mktime(0, 0, 0, $mes, $diap, $ano));

                $params['vencimento'] = $newDate;
            }
        } else {
            $params['uuid'] = Str::uuid();
            $params['company_id'] = $this->currentUser->company_id;
            $params['vendedor_id'] = $this->currentUser->uuid;
            $params['vendedor'] = $this->currentUser->nome;
            $conta = Conta::create($params);
            $conta->documento = str_pad($conta->id, 7, "0", STR_PAD_LEFT) . "/1";
            if (!$conta->save()) {
                return response()->json(['message' => 'Falha ao cadastrar conta'], 500);
            }
        }

        return response()->json(['message' => 'conta cadastrada.'], 201);
    }

    public function paymentConta(Request $request)
    {
        $params = $request->all();

        $payments = $params['payments'];
        $_dados = $params['dados'];
        $contas = $params['contas'];

        foreach ($contas as $conta) {
            // print_r($conta);
            $dados = Conta::where('uuid', $conta['uuid'])->first();
            // if (empty($dados)) {
            //     continue;
            // }
            $dados->fill($conta);

            $dados->valor_pago = $conta['valor_pago'];
            $dados->situacao = 10;
            $dados->data_pago = $_dados['data_pago'];

            $dados->save();
        }

        $this->geraCaixa($payments, $_dados, 2);
    }

    public function getContaById($uuid)
    {
        $resp = Conta::with('categoria')->where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Conta não encontrado'], 500);
        }

        return response()->json($resp);
    }

    public function updateConta(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = Conta::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Conta não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar Conta'], 500);
        }

        return response()->json(['message' => 'Conta atualizado.'], 201);
    }

    public function deleteConta($uuid)
    {
        $resp = Conta::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Conta não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar Conta'], 500);
        }

        return response()->json(['message' => 'Conta deletada.'], 201);
    }

    //categoria Contas
    public function listingContaCategories(Request $request)
    {
        $params = $request->all();
        $resp = ContaCategoria::where('company_id', $this->currentUser->company_id);
        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp->data = $resp->get();
        }

        $counts = $this->countsContas();

        return response()->json(['paginate' => $resp, 'counts' => $counts]);
    }

    public function createContaCategory(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = Str::uuid();
        $dados['company_id'] = $this->currentUser->company_id;
        $resp = ContaCategoria::create($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao cadastrar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria cadastrada.'], 201);
    }

    public function getContaCategoryById($uuid)
    {
        $resp = ContaCategoria::where('uuid', $uuid)->first();

        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrada'], 500);
        }

        return response()->json($resp);
    }

    public function updateContaCategory(Request $request, $uuid)
    {
        $dados = $request->all();

        $resp = ContaCategoria::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        $resp->fill($dados);
        if (!$resp->save()) {
            return response()->json(['message' => 'Falha ao atualizar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria atualizado.'], 201);
    }

    public function deleteContaCategory($uuid)
    {
        $resp = ContaCategoria::where('uuid', $uuid)->first();
        if (empty($resp)) {
            return response()->json(['message' => 'Categoria não encontrado'], 500);
        }

        if (!$resp->delete()) {
            return response()->json(['message' => 'Falha ao deletar categoria'], 500);
        }

        return response()->json(['message' => 'Categoria deletada.'], 201);
    }

    public function gerar($uuid){

        try{
            DB::beginTransaction();

            if(Receita::where('contrato_id', '=', $uuid)->exists()){
                return response()->json(['message' => 'Contrato já possui financeiro'], 500);
            }

            $contrato = Contrato::where('uuid', '=', $uuid)->first();

            $nContratos = Contrato::where('cliente_id', '=', $contrato->cliente_id)->count();

            $receita = Receita::create([
                'description' => 'Contrato: ' . $contrato->cliente->nome . ' / ' . $nContratos,
                'documento' => '001',
                'valor' => $contrato->valor_contrato,
                'vencimento' => $contrato->data_faturamento,
                'uuid' => Str::uuid(),
                'company_id' => $contrato->company_id,
                'cliente_id' => $contrato->cliente_id,
                'cliente' => $contrato->cliente->nome,
                'vendedor_id' => $contrato->vendedor_id,
                'contrato_id' => $contrato->uuid
            ]);

            if($contrato->formaPagamento->id_sefaz == 15){
                $boleto = Boletos::create(
                    [
                        'uuid' => Str::uuid(),
                        'emitente_id' => Emitente::first()->uuid,
                        'pagador_id' => $contrato->cliente_id,
                        'banco_id' => 1,
                        'cfgBoleto_id' => CfgBoletos::first()->uuid,
                        'emissao' => Carbon::now()->toDateString(),
                        'vencimento' => $contrato->data_faturamento,
                        'valor' => $contrato->valor_contrato,
                        'company_id' => $contrato->company_id,
                        'numero' => (Boletos::where('emitente_id','=', Emitente::first()->uuid)
                                    ->withTrashed()
                                    ->count()) + 1

                    ]
                );
                $receita->documento = $boleto->uuid;
                $receita->isBoleto = true;
                $receita->save();

                $contrato->gerar_financeiro = 1;
                $contrato->save();
                $emit = (new BoletoBBService())->emitirBoleto($boleto->uuid);

                if($emit['code'] == 200){
                    Log::info($emit);
                    DB::commit();
                    return response()->json(['message' => 'Financeiro e boleto gerado com suscesso']);
                }

                DB::rollBack();

                return response()->json(['message' => $emit['description']], 500);
            }

            DB::commit();

            return response()->json(['message' => 'Financeiro e boleto gerado com suscesso'], 200);
        }catch (\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['message' => 'Erro ao gerar financeiro'], 500);
        }
    }
}
