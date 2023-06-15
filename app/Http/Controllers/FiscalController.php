<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Emitente;
use App\Models\FiscalNFSe;
use App\Models\MonitorFiscal;
use App\Models\MonitorFiscalEventos;
use App\Models\NFe;
use App\Models\NFeImport;
use App\Models\Pessoal;
use App\Models\Product;
use App\Models\ProductMovimento;
use App\Models\User;
use App\Services\NotaService;
use App\Services\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FiscalController extends Controller
{
    protected User $user;
    protected Tools $util;

    function __construct(Request $request)
    {
        $this->user = $request->user();
        $this->util = new Tools();
    }

    public function listing(Request $request)
    {
        $params = $request->all();
        $emitente = Emitente::where('uuid', $params['emitente_id'])->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado.'], 500);
        }

        $resp = MonitorFiscal::where('emitente_id', $emitente->uuid)->orderBy('data', 'desc');

        if (isset($params['termo']) && !empty($params['termo'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('razao', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('chave', 'like', '%' . $params['termo'] . '%')
                    ->orWhere('cnpj', 'like', '%' . $params['termo'] . '%');
            });
        }

        $resp = $resp->paginate($params['per_page']);

        foreach ($resp as $item) {
            $pathXml = "{$request->user()->company_id}/XML/{$emitente->cnpj}/monitor/notas/{$item->chave}.xml";

            $item->pathXml = Storage::disk('public')->exists($pathXml);

            $item->eventos = MonitorFiscalEventos::where('chave', $item->chave)->where('emitente_id', $item->emitente_id)->get();

            $item->import = NFeImport::where('chave', 'like', $item->chave)->where('company_id', $request->user()->company_id)->first();
        }

        return response()->json(['paginate' => $resp]);
    }

    public function listingNFSe(Request $request)
    {
        $params = $request->all();

        return FiscalNFSe::where(function($q) use ($params){
            if(isset($params['dtInicio']) && isset($params['dtFim'])){
                $q->where('created_at', '>=', $params['dtInicio'])
                    ->where('created_at', '<=', $params['dtFim']);
            }
        })->where(function($w) use ($params){
            if(isset($params['emitente_id'])){
                $w->where('emitente_id', '=', $params['emitente_id']);
            }
        })->where(function($p) use ($params){
            if(isset($params['pagador_id'])){
                $p->where('pagador_id', '=', $params['pagador_id']);
            }
        })->where('company_id', '=', $request->user()->company_id)
            ->paginate($params['per_page'] ?? 20)
            ->map(function($x){

                $x->emitente_desc = $x->emitente->razao;
                $x->im = $x->emitente->inscricao_municipal;
                $x->pagador_desc = $x->pagador->nome;
               // $x->total = $x->contrato->valor_contrato;

                $x->total = Contrato::where('uuid', '=', $x->contrato_id)->first()['valor_contrato'];

                unset($x->emitente);
                unset($x->pagador);
                unset($x->contrato);

                return $x;
            });
    }

    public function searching(Request $request)
    {
        $params = $request->all();

        $emitente = Emitente::where('uuid', $params['emitente_id'])->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado.'], 500);
        }

        $notaService = new NotaService($emitente);

        $result = $notaService->monitorFiscal($emitente->ultNSU);
        if ($result) {
            return response()->json(['message' => 'Novos registros encontrados'], 201);
        } else {
            return response()->json(['message' => 'Nenhum documento encontrado'], 201);
        }
    }

    public function manifestaNFe(Request $request)
    {
        $params = $request->all();

        $emitente = Emitente::where('uuid', $params['emitente_id'])->first();
        if (empty($emitente)) {
            return response()->json(['message' => 'Emitente não encontrado.'], 500);
        }

        $sequencia = MonitorFiscalEventos::where('chave', $params['chave'])->where('emitente_id', $emitente->emitente_id)->max('sequencia');
        $params['sequencia'] = $sequencia > 0 ? $sequencia : 1;

        $notaService = new NotaService($emitente);

        $result = $notaService->manifestarNFe($params);
        if (is_array($result) && isset($result['error'])) {
            return response()->json(['message' => $result['error']], 500);
        } else {

            $resultDownload = $notaService->downloadNFe($params);

            return response()->json(['message' => 'Nota manifestada com sucesso!', 'resultDownload' => $resultDownload], 201);
        }
    }

    //extract xml for import
    public function getDadosXML(Request $request)
    {
        $params = $request->all();
        $emitente_id = $params['emitente_id'];
        $chave = $params['chave'];

        $verify = NFeImport::where('chave', 'like', $chave)->where('company_id', $request->user()->company_id)->get();
        if (count($verify) > 0) {
            return array('error' => "Esta nota ja foi importada!");
        }

        $emitente = Emitente::where('uuid', $emitente_id)->first();

        $pathRoot = "{$emitente->company_id}/XML/{$emitente->cnpj}";

        $localXML = "{$pathRoot}/monitor/notas/{$chave}.xml";

        $dados = $this->extractXML($localXML, $emitente->crt);

        return $dados;
    }
    private function extractXML($pathXML, $crt)
    {
        $xml = Storage::disk('public')->get($pathXML);

        $dados = simplexml_load_string($xml);

        $nfe = $dados->NFe->infNFe;

        $return['ide'] = [
            'numero_nfe' => (string) $nfe->ide->nNF,
            'data_emissao' => (string) date('Y-m-d', strtotime($nfe->ide->dhEmi)),
            'chave' => (string) $dados->protNFe->infProt->chNFe,

            'subtotal' => (string) $nfe->total->ICMSTot->vProd,
            'descontos' => (string) $nfe->total->ICMSTot->vDesc,
            'frete' => (string) $nfe->total->ICMSTot->vFrete,
            'total' => (string) $nfe->total->ICMSTot->vNF,
        ];

        $return['fornecedor'] = [
            'nome' => (string) $nfe->emit->xNome,
            'apelido' => (string) $nfe->emit->xFant,
            'cpf' => (string) $nfe->emit->CNPJ,
            'identidade' => (string) $nfe->emit->IE,

            'cep' => (string) $this->util->soNumero($nfe->emit->enderEmit->CEP),
            'logradouro' => (string) $nfe->emit->enderEmit->xLgr,
            'numero' => (string) $nfe->emit->enderEmit->nro,
            'bairro' => (string) $nfe->emit->enderEmit->xBairro,
            'cidade' => (string) $nfe->emit->enderEmit->xMun,
            'uf' => (string) $nfe->emit->enderEmit->UF,
            'ibge' => (string) $nfe->emit->enderEmit->cMun,
        ];
        $checkFornecedor = Pessoal::where('cpf', $return['fornecedor']['cpf'])->where('company_id', $this->user->company_id)->first();
        if (!empty($checkFornecedor)) {
            $return['fornecedor']['categoria_id'] = $checkFornecedor->categoria_id;
        }

        $return['itens'] = $this->getItems($nfe->det, $crt);

        $return['fatura'] = isset($nfe->cobr) ? $this->getFaturas($nfe->cobr, $return) : [];

        // return $dados;
        return $return;
    }
    private function getItems($det, $crt)
    {
        $itens = array();
        foreach ($det as $item) {

            $produto = [
                'company_id' => $this->user->company_id,
                'codigo_barras' => (string) ($item->prod->cEAN == "SEM GTIN") ? null : (string) $item->prod->cEAN,
                'nome' => (string) $item->prod->xProd,
                'referencia' => (string) $item->prod->cProd,
                'valor_custo' => (string) $item->prod->vUnCom,
                'margem' => 0,
                'valor_venda' => (string) $item->prod->vUnCom,
                'quantidade' => (string) $item->prod->qCom,
                'medida' => (string) $item->prod->uCom,
                'ncm' => (string) $item->prod->NCM,
                'cfop' => (string) $item->prod->CFOP,
            ];

            $product = Product::where('company_id', $this->user->company_id);

            if (!empty($produto['codigo_barras'])) {
                $product = $product->where('codigo_barras', 'like', $produto['codigo_barras']);
            }
            // if (!empty($produto['referencia'])) {
            $product = $product->where('referencia', 'like', $produto['referencia']);
            // }

            $produto['product'] = $product->first();

            //ICMS
            $imposto = $this->getImposto($item, $crt);

            $produto['origin'] = $imposto['origin'];
            $produto['cst_icms'] = $imposto['cst_icms'];
            $produto['p_icms'] = $imposto['p_icms'];

            //IPI
            $produto['cst_ipi'] = (string) $imposto['cst_ipi'];
            $produto['p_ipi'] = (string) $imposto['p_ipi'];

            //PIS
            $produto['cst_pis'] = (string) $imposto['cst_pis'];
            $produto['p_pis'] = (string) $imposto['p_pis'];

            //COFINS
            $produto['cst_cofins'] = (string) $imposto['cst_cofins'];
            $produto['p_cofins'] = (string) $imposto['p_cofins'];

            array_push($itens, $produto);
        }

        return $itens;
    }
    private function getImposto($item, $crt)
    {
        if ($crt == 1) { // simples nacional
            if (isset($item->imposto->ICMS->ICMS00)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS00->orig;
                $imposto['cst_icms'] = (string) 102;
                $imposto['p_icms'] = 0;
            } elseif (isset($item->imposto->ICMS->ICMS10)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS10->orig;
                $imposto['cst_icms'] = (string) 202;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS10->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS20)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS20->orig;
                $imposto['cst_icms'] = (string) 102;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS20->pICMS;
            } elseif (isset($item->imposto->ICMS->ICMS30)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS30->orig;
                $imposto['cst_icms'] = (string) 202;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS30->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS40)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS40->orig;
                $imposto['cst_icms'] = (string) 103;
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS50)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS50->orig;
                $imposto['cst_icms'] = (string) 400;
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS51)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS51->orig;
                $imposto['cst_icms'] = (string) 900;
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS60)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS60->orig;
                $imposto['cst_icms'] = (string) 500;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS60->pST;
            } elseif (isset($item->imposto->ICMS->ICMS70)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS70->orig;
                $imposto['cst_icms'] = (string) 201;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS70->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS90)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS90->orig;
                $imposto['cst_icms'] = (string) 102;
                $imposto['p_icms'] = (string) 0;
            }
            /////////////////////////////////////////////////
            elseif (isset($item->imposto->ICMS->ICMSSN101)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN101->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN101->CSOSN;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMSSN101->pCredSN;
            } elseif (isset($item->imposto->ICMS->ICMSSN102)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN102->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN102->CSOSN;
                $imposto['p_icms'] = 0;
            } elseif (isset($item->imposto->ICMS->ICMSSN201)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN201->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN201->CSOSN;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMSSN201->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMSSN202)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN202->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN202->CSOSN;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMSSN202->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMSSN500)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN500->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN500->CSOSN;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMSSN500->pST;
            } elseif (isset($item->imposto->ICMS->ICMSSN900)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMSSN900->orig;
                $imposto['cst_icms'] = (string) $item->imposto->ICMS->ICMSSN900->CSOSN;
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMSSN900->pICMSST;
            }
        } else {
            if (isset($item->imposto->ICMS->ICMS00)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS00->orig;
                $imposto['cst_icms'] = (string) '00';
                $imposto['p_icms'] = 0;
            } elseif (isset($item->imposto->ICMS->ICMS10)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS10->orig;
                $imposto['cst_icms'] = (string) '10';
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS10->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS20)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS20->orig;
                $imposto['cst_icms'] = (string) '20';
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS20->pICMS;
            } elseif (isset($item->imposto->ICMS->ICMS30)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS30->orig;
                $imposto['cst_icms'] = (string) '30';
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS30->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS40)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS40->orig;
                $imposto['cst_icms'] = (string) '40';
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS50)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS50->orig;
                $imposto['cst_icms'] = (string) '50';
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS51)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS51->orig;
                $imposto['cst_icms'] = (string) '51';
                $imposto['p_icms'] = (string) 0;
            } elseif (isset($item->imposto->ICMS->ICMS60)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS60->orig;
                $imposto['cst_icms'] = (string) '60';
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS60->pST;
            } elseif (isset($item->imposto->ICMS->ICMS70)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS70->orig;
                $imposto['cst_icms'] = (string) '70';
                $imposto['p_icms'] = (string) $item->imposto->ICMS->ICMS70->pICMSST;
            } elseif (isset($item->imposto->ICMS->ICMS90)) {
                $imposto['origin'] = (string) $item->imposto->ICMS->ICMS90->orig;
                $imposto['cst_icms'] = (string) '90';
                $imposto['p_icms'] = (string) 0;
            } else {
                $imposto['origin'] = (string) 0;
                $imposto['cst_icms'] = (string) '41';
                $imposto['p_icms'] = (string) 0;
            }
        }


        //IPI
        if (isset($item->imposto->IPI->IPITrib)) {
            $imposto['cst_ipi'] = $item->imposto->IPI->IPITrib->CST;
            $imposto['p_ipi'] = isset($item->imposto->IPI->IPITrib->pIPI) ? $item->imposto->IPI->IPITrib->pIPI : 0;
        } elseif (isset($item->imposto->IPI)) {
            $imposto['cst_ipi'] = $item->imposto->IPI->IPINT->CST;
            $imposto['p_ipi'] = isset($item->imposto->IPI->IPINT->pIPI) ? $item->imposto->IPI->IPINT->pIPI : 0;
        } else {
            $imposto['cst_ipi'] = 52;
            $imposto['p_ipi'] = 0;
        }

        //PIS
        if (isset($item->imposto->PIS->PISAliq)) {
            $imposto['cst_pis'] = $item->imposto->PIS->PISAliq->CST;
            $imposto['p_pis'] = isset($item->imposto->PIS->PISAliq->pPIS) ? $item->imposto->PIS->PISAliq->pPIS : 0;
        } else {
            $imposto['cst_pis'] = $item->imposto->PIS->PISNT->CST;
            $imposto['p_pis'] = isset($item->imposto->PIS->PISNT->pPIS) ? $item->imposto->PIS->PISNT->pPIS : 0;
        }

        //PIS
        if (isset($item->imposto->COFINS->COFINSAliq)) {
            $imposto['cst_cofins'] = $item->imposto->COFINS->COFINSAliq->CST;
            $imposto['p_cofins'] = isset($item->imposto->COFINS->COFINSAliq->pCOFINS) ? $item->imposto->COFINS->COFINSAliq->pCOFINS : 0;
        } else {
            $imposto['cst_cofins'] = $item->imposto->COFINS->COFINSNT->CST;
            $imposto['p_cofins'] = isset($item->imposto->COFINS->COFINSNT->pCOFINS) ? $item->imposto->COFINS->COFINSNT->pCOFINS : 0;
        }

        return $imposto;
    }
    private function getFaturas($item, $nfe)
    {
        $fatura = [
            'numero_fatura' => (string) $item->fat->nFat,
            'subtotal' => (string) $item->fat->vOrig,
            'desconto' => (string) $item->fat->vDesc,
            'total' => (string) $item->fat->vLiq,
        ];

        $duplicatas = array();
        $i = 0;
        foreach ($item->dup as $duplicata) {
            $i++;
            $array = [
                'company_id' => (string) $this->user->company_id,
                'cliente' => (string) $nfe['fornecedor']['nome'],
                'description' => (string) "Duplicata da nota de Nº:" . $nfe['ide']['numero_nfe'],
                'documento' => (string) $fatura['numero_fatura'] . "/" . $duplicata->nDup,
                'valor' => (string) $duplicata->vDup,
                'vencimento' => (string) $duplicata->dVenc
            ];

            array_push($duplicatas, $array);
        }

        $fatura['duplicatas'] = $duplicatas;

        return $fatura;
    }


    // import nota
    public function importDadosXML(Request $request)
    {
        $params = $request->all();

        $fatura = $params['fatura'];
        $itens = $params['itens'];
        $ide = $params['ide'];
        $fornecedor = $params['fornecedor'];

        $this->importItens($itens, $ide);

        if (isset($fatura['duplicatas'])) {
            $this->importFatura($fatura, $fornecedor);
        }


        //add fornecedor
        $checkFornecedor = Pessoal::where('cpf', $fornecedor['cpf'])->where('company_id', $this->user->company_id)->first();
        if (empty($checkFornecedor)) {
            $fornecedor['uuid'] = Str::uuid();
            $fornecedor['company_id'] = $this->user->company_id;
            Pessoal::create($fornecedor);
        } else {
            $checkFornecedor->fill($fornecedor);
            $checkFornecedor->save();
        }

        $import = NFeImport::create([
            'uuid' => Str::uuid(),
            'company_id' => $this->user->company_id,
            'chave' => $ide['chave'],
            'numero_nfe' => $ide['numero_nfe'],
        ]);

        $import->save();

        return response()->json(['message' => 'nota importada com sucesso.'], 201);
    }

    private function importItens($itens, $ide)
    {
        foreach ($itens as $item) {

            if ($item['product'] != null) {
                $produto = Product::where('uuid', $item['product']['uuid'])->first();
                $produto->codigo_barras += $item['codigo_barras'];
                $produto->referencia += $item['referencia'];

                $produto->estoque_atual += floatval($item['quantidade']);

                $produto->valor_custo = floatval($item['valor_custo']);
                $produto->margem = floatval($item['margem']);
                $produto->valor_venda = floatval($item['valor_venda']);
                if ($produto->save()) {
                    ProductMovimento::create([
                        'produto_id' => $produto->uuid,
                        'valor_custo' => $produto->valor_custo,
                        'quantidade' => $item['quantidade'],
                        'nota' => $ide['numero_nfe']
                    ]);
                }
            } else {

                $item['uuid'] = Str::uuid();
                $produto = Product::create($item);
                $produto->estoque_atual += floatval($item['quantidade']);
                if ($produto->save()) {
                    ProductMovimento::create([
                        'produto_id' => $produto->uuid,
                        'valor_custo' => $produto->valor_custo,
                        'quantidade' => $item['quantidade'],
                        'nota' => $ide['numero_nfe']
                    ]);
                }
            }
        }
    }
    private function importFatura($fatura, $ide)
    {
        // foreach ($fatura['duplicatas'] as $item) {
        //     $conta = ContasPagar::create($item);

        //     $conta->save();
        // }
    }




    //references
    public function getListingReferences(Request $request)
    {
        $params = $request->all();
        if ($params['tipo'] == 1) {
            $resp = NFeImport::select('chave', 'numero_nfe')->where('company_id', $this->user->company_id)->where(function ($query) use ($params) {
                $query->orWhere('chave', 'like', "%{$params['termo']}%")->orWhere('numero_nfe', 'like', "%{$params['termo']}%");
            })->limit(30)->get();
        } else {
            $resp = NFe::select('chave', DB::raw('sequencia as numero_nfe'))->where('company_id', $this->user->company_id)
                ->where('cstatus', 100)->where('cstatus', 101)->where('cstatus', 135)->where('cstatus', 155)
                ->where(function ($query) use ($params) {
                    $query->orWhere('chave', 'like', "%{$params['termo']}%")->orWhere('sequencia', 'like', "%{$params['termo']}%");
                })->limit(30)->get();
        }

        return response()->json($resp);
    }
}
