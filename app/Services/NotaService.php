<?php

namespace App\Services;

use App\Models\Emitente;
use App\Models\MonitorFiscal;
use App\Models\MonitorFiscalEventos;
use App\Models\NFeImport;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use Illuminate\Support\Facades\Storage;
use NFePHP\NFe\Common\Standardize;
use Illuminate\Support\Str;
use InvalidArgumentException;
use NFePHP\Common\Keys;
use NFePHP\NFe\Complements;
use NFePHP\NFe\Make;
use NFePHP\DA\NFe\Danfe;

class NotaService
{
    public const VERSION = '4.00';

    public const NATURE_OPERATION = 'VENDA';

    public const COUNTRY_CODE = '1058';
    public const COUNTRY_NAME = 'BRASIL';

    public const PAY_ICMS = 1;
    public const FREE_ICMS = 9;

    protected $emitente;
    protected $dados;
    protected $items;
    protected $payments;

    protected $xml;

    private $_statesCode = [
        'RO' => 11, 'AC' => 12, 'AM' => 13, 'RR' => 14, 'PA' => 15, 'AP' => 16,
        'TO' => 17, 'MA' => 21, 'PI' => 22, 'CE' => 23, 'RN' => 24, 'PB' => 25,
        'PE' => 26, 'AL' => 27, 'SE' => 28, 'BA' => 29, 'MG' => 31, 'ES' => 32,
        'RJ' => 33, 'SP' => 35, 'PR' => 41, 'SC' => 42, 'RS' => 43, 'MS' => 50,
        'MT' => 51, 'GO' => 52, 'DF' => 53
    ];

    protected $tools;
    protected $nfe;
    protected $modelo;
    function __construct(Emitente $emitente, $modelo = 55)
    {
        $this->modelo = $modelo;
        $this->emitente = $emitente;
        $this->pathRoot = "{$emitente->company_id}/XML/{$emitente->cnpj}";

        if (isset($emitente->config)) {
            $this->pathModelo = $modelo == 55 ? "NFe" : "NFCe";
            $this->pathAmbiente = $emitente->config->tipo_ambiente == 1 ? "producao" : "homologacao";

            $this->pathGerados = "{$this->pathRoot}/{$this->pathModelo}/{$this->pathAmbiente}/geradas";
            $this->pathAutorizados = "{$this->pathRoot}/{$this->pathModelo}/{$this->pathAmbiente}/autorizadas";
            $this->pathCancelados = "{$this->pathRoot}/{$this->pathModelo}/{$this->pathAmbiente}/canceladas";

            $this->tipo_ambiente = $emitente->config->tipo_ambiente;
            $this->numero = ($this->tipo_ambiente == 1) ? $this->emitente->config->sequencia : $this->emitente->config->sequencia_homolog;
            $this->serie = ($this->tipo_ambiente == 1) ? $this->emitente->config->serie : $this->emitente->config->serie_homolog;
        }



        $this->pathMonitor = "{$this->pathRoot}/monitor";

        $this->data_emissao = date('Y-m-d H:i:s');

        $config = [
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => 2,
            "razaosocial" => $emitente->razao,
            "siglaUF" => $emitente->uf,
            "cnpj" => $emitente->cnpj,
            "schemes" => "PL_008i2",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];
        if ($this->modelo == 65) {
            $config["CSC"] = ($emitente->config->tipo_ambiente == 1) ? $emitente->config->csc : $emitente->config->csc_homolog;
            $config["CSCid"] = ($emitente->config->tipo_ambiente == 1) ? $emitente->config->csc_id : $emitente->config->csc_id_homolog;
        }

        $configJson = json_encode($config);

        try {
            $pfx_content = Storage::disk('public')->get($emitente->file_pfx);
            $certificate = Certificate::readPfx($pfx_content, $emitente->senha_pfx);
            $this->tools = new Tools($configJson, $certificate);
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $this->tools->model($modelo);
    }

    private function gen_IDE()
    {
        $std = new \stdClass();
        $std->versao = self::VERSION;
        $this->nfe->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = $this->_getStateCode($this->emitente->uf);
        $std->cNF = STR_PAD($this->numero + 1, 8, '0', STR_PAD_LEFT);
        $std->natOp = isset($this->dados->natOp) ? $this->dados->natOp : "Venda";
        // $std->indPag = $payment;
        $std->mod = $this->modelo;
        $std->serie = $this->serie;
        $std->nNF = $this->numero;
        $std->dhEmi = date('Y-m-d\TH:i:sP', strtotime($this->data_emissao));
        $std->dhSaiEnt = date('Y-m-d\TH:i:sP', strtotime($this->data_emissao));
        $std->tpNF = $this->emitente->config->tipo_nota;

        if ($this->modelo == 55) {
            $std->idDest = ($this->_getStateCode($this->emitente->uf) != $this->_getStateCode($this->dados->uf)) ? 2 : 1;
        } else {
            $std->idDest = 1;
        }

        $std->cMunFG = $this->emitente->ibge;
        $std->tpImp = $this->emitente->config->tipo_impressao;
        $std->tpEmis = $this->emitente->config->tipo_emissao;
        // $std->cDV = 0;
        $std->tpAmb = $this->emitente->config->tipo_ambiente;
        $std->finNFe = isset($this->dados->finalidade_nf) ? $this->dados->finalidade_nf : 1;
        $std->indFinal = isset($this->dados->ind_final) ? $this->dados->ind_final : 1;
        $std->indPres = isset($this->dados->ind_pres) ? $this->dados->ind_pres : 1;
        $std->procEmi = 0;
        $std->verProc = 'ERP-HPI-0.0.1';

        // Monta Chave da NF-e
        $this->chave = Keys::build(
            $std->cUF,
            date('y', strtotime($std->dhEmi)),
            date('m', strtotime($std->dhEmi)),
            $this->emitente->cnpj,
            $std->mod,
            $std->serie,
            $std->nNF,
            $std->tpEmis,
            $std->cNF
        );

        $std->cDV = substr($this->chave, -1);

        $this->nfe->tagide($std);

        //verifica se tem referencias na nota
        if (isset($this->dados->references)) {

            foreach ($this->dados->references as $reference) {
                $std = new \stdClass();
                $std->refNFe = $reference->chave;
                $this->nfe->tagrefNFe($std);
            }
        }
    }

    private function get_Emitente()
    {
        $std = new \stdClass();
        $std->xNome = $this->emitente->razao;
        $std->IE = $this->emitente->inscricao_estadual;
        $std->CRT = $this->emitente->crt;
        $std->CNPJ = $this->emitente->cnpj;
        $this->nfe->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = $this->emitente->logradouro;
        $std->nro = $this->emitente->numero;
        $std->xBairro = $this->emitente->bairro;
        $std->cMun = $this->emitente->ibge;
        $std->xMun = $this->emitente->cidade;
        $std->UF = $this->emitente->uf;
        $std->CEP = $this->emitente->cep;
        $std->cPais = self::COUNTRY_CODE;
        $std->xPais = self::COUNTRY_NAME;
        $this->nfe->tagenderEmit($std);
    }

    private function gen_Destinatario()
    {
        if (!isset($this->dados->cnpj) || empty($this->dados->cnpj)) {
            return;
        }

        $std = new \stdClass();
        $std->xNome = $this->dados->nome;

        if ($this->modelo == 55) {
            $std->indIEDest = $this->dados->inscricao_estadual
                ? self::PAY_ICMS
                : self::FREE_ICMS;
            $std->IE = $this->dados->inscricao_estadual;
        } else {
            $std->indIEDest = self::FREE_ICMS;
        }

        if (strlen($this->dados->cnpj) == 11) {
            $std->CPF = $this->dados->cnpj;
        } else {
            $std->CNPJ = $this->dados->cnpj;
        }
        $this->nfe->tagdest($std);

        if (empty($this->dados->ibge)) {
            return;
        }

        $std = new \stdClass();
        $std->xLgr = $this->dados->logradouro;
        $std->nro = $this->dados->numero;
        $std->xBairro = $this->dados->bairro;
        $std->cMun = $this->dados->ibge;
        $std->xMun = $this->dados->cidade;
        $std->UF = $this->dados->uf;
        $std->CEP = $this->dados->cep;
        $std->cPais = $this->dados->cPais ?? self::COUNTRY_CODE;
        $std->xPais = $this->dados->xPais ?? self::COUNTRY_NAME;
        $this->nfe->tagenderDest($std);
    }

    private function gen_itens_nfce()
    {
        $this->desconto_venda = $this->dados->desconto;
        $this->total_items = 0;
        $this->total_desconto = 0;

        $this->total_BC = 0;
        $this->total_ICMS = 0;
        $this->total_IPI = 0;
        $this->total_PIS = 0;
        $this->total_COFINS = 0;
        foreach ($this->items as $i => $item) {
            $cfop = "5" . substr($item->product->cfop, 1);


            $std = new \stdClass();
            $std->item = $i = $i + 1;
            $std->cProd = $item->product->referencia;
            $std->xProd = $item->product->nome;
            $std->NCM = $item->product->ncm;
            $std->CFOP = $cfop;
            $std->uCom = $item->product->unidade;
            $std->uTrib = $std->uCom;
            $std->qTrib = $std->qCom = number_format($item->quantidade, 2, '.', '');
            $std->vUnTrib = number_format($item->valor_unitario, 2, '.', '');
            $std->vUnCom = number_format($item->valor_unitario, 2, '.', '');
            $std->vProd = number_format($std->qCom * $std->vUnCom, 2, '.', '');
            $std->cEAN  = $std->cEANTrib = (!empty($item->product->codigo_barras)) ? $item->product->codigo_barras : 'SEM GTIN';
            $std->vDesc = ($item->desconto > 0) ? $item->desconto : null;
            $std->indTot = 1;

            $total_item = $std->vProd - $std->vDesc;

            if ($this->desconto_venda > 0) {

                if ($this->desconto_venda > $total_item) {
                    $std->vDesc += $total_item;
                    $this->desconto_venda -= $total_item;
                } else {
                    $std->vDesc += $this->desconto_venda;
                    $this->desconto_venda = 0;
                }
            }

            if ($std->vDesc > 0) {
                $std->vDesc = number_format($std->vDesc, 2, '.', '');
                $this->total_desconto += $std->vDesc;
            }
            $this->total_items += $std->vProd;


            $this->nfe->tagprod($std);

            $std = new \stdClass();
            $std->item = $i;
            $this->nfe->tagimposto($std);

            if ($this->emitente->crt == 1) { //simples nacional

                if ($item->product->cst_icms == '102') {
                    $std = new \stdClass();
                    $std->item = $i;
                    $std->orig = $item->product->origem;
                    $std->CSOSN = '102';
                    $this->nfe->tagICMSSN($std);
                } else {
                    $std = new \stdClass();
                    $std->item = $i;
                    $std->orig = $item->product->origem;
                    $std->CSOSN = $item->product->cst_icms;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->product->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);

                    $this->total_BC += $total_item;
                    $this->total_ICMS += $std->vICMS;

                    $this->nfe->tagICMSSN($std);
                }

                //PIS - Programa de Integração Social]
                $std = new \stdClass();
                $std->item = $i; //produtos 1
                $std->CST = '07';
                $std->vBC = $total_item;
                $std->pPIS = 0;
                $std->vPIS = $std->vBC * ($std->pPIS / 100);

                $this->total_PIS += $std->vPIS;
                $this->nfe->tagPIS($std);

                //COFINS - Contribuição para o Financiamento da Seguridade Social
                $std = new \stdClass();
                $std->item = $i; //produtos 1
                $std->CST = '07';
                $std->vBC = $total_item;
                $std->pCOFINS = 0;
                $std->vCOFINS = $std->vBC * ($std->pCOFINS / 100);

                $this->total_COFINS += $std->vCOFINS;
                $this->nfe->tagCOFINS($std);
            } else {
                // icms//
                $std = new \stdClass();
                $std->item = $i;
                $std->orig = 0;
                $std->CST = $item->product->cst_icms;

                if ($item->product->cst_icms == "00") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->product->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                } elseif ($item->product->cst_icms == "10") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->product->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->product->cst_icms == "20") {
                    $std->modBC = 3;
                    $std->pRedBC = 0;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->product->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                } elseif ($item->product->cst_icms == "30") {
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->product->cst_icms == "40") {
                } elseif ($item->product->cst_icms == "41") {
                    $std->vBCSTRet = 0.00;
                    $std->vICMSSTRet = 0.00;
                } elseif ($item->product->cst_icms == "50") {
                } elseif ($item->product->cst_icms == "51") {
                } elseif ($item->product->cst_icms == "60") {
                    $std->vBCSTRet = 0.00;
                    $std->vICMSSTRet = 0.00;
                } elseif ($item->product->cst_icms == "70") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->product->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->product->cst_icms == "90") {
                }

                $this->nfe->tagICMS($std);

                //pis
                $std = new \stdClass();
                $std->item = $i; //item da NFe
                $std->CST = $item->product->cst_pis;
                $std->vBC = $total_item;
                $std->pPIS = $item->product->p_pis;
                $std->vPIS = $std->vBC * ($std->pPIS / 100);
                $this->total_PIS += $std->vPIS;
                $std->qBCProd = null;
                $std->vAliqProd = null;

                $this->nfe->tagPIS($std);


                $std = new \stdClass();
                $std->item = $i; //item da NFe
                $std->CST = $item->product->cst_cofins;
                $std->vBC = $total_item;
                $std->pCOFINS = $item->product->p_cofins;
                $std->vCOFINS = $std->vBC * ($std->pCOFINS / 100);
                $this->total_COFINS += $std->vCOFINS;
                $std->qBCProd = null;
                $std->vAliqProd = null;

                $this->nfe->tagCOFINS($std);
            }
        }

        $std = new \stdClass();
        $std->vBC = $this->total_BC;
        $std->vICMS = $this->total_ICMS;
        $std->vICMSDeson = "0.00";
        $std->vFCP = "0.00"; //incluso no layout 4.00
        $std->vBCST = "0.00";
        $std->vST = "0.00";
        $std->vFCPST = "0.00"; //incluso no layout 4.00
        $std->vFCPSTRet = "0.00"; //incluso no layout 4.00
        $std->vProd = $this->total_items;
        $std->vFrete = "0.00";
        $std->vSeg = "0.00";
        $std->vDesc = $this->total_desconto;
        $std->vII = "0.00";
        $std->vIPI = $this->total_IPI;
        $std->vIPIDevol = "0.00"; //incluso no layout 4.00
        $std->vPIS = $this->total_PIS;
        $std->vCOFINS = $this->total_COFINS;
        $std->vOutro = "0.00";
        $std->vNF = $this->total_items - $this->total_desconto;
        $std->vTotTrib = "0.00";

        $this->nfe->tagICMSTot($std);
    }
    private function gen_itens_nfe()
    {
        $this->total_items = 0;
        $this->total_desconto = 0;

        $this->total_BC = 0;
        $this->total_ICMS = 0;
        $this->total_IPI = 0;
        $this->total_PIS = 0;
        $this->total_COFINS = 0;
        foreach ($this->items as $i => $item) {
            $cfop = ($this->_getStateCode($this->emitente->uf) != $this->_getStateCode($this->dados->uf))
                ? "6" . substr($item->cfop, 1)
                : "5" . substr($item->cfop, 1);


            $std = new \stdClass();
            $std->item = $i = $i + 1;
            $std->cProd = $item->product->referencia;
            $std->xProd = $item->produto;
            $std->NCM = $item->ncm;
            $std->CFOP = $cfop;
            $std->uCom = $item->product->unidade;
            $std->uTrib = $std->uCom;
            $std->qTrib = $std->qCom = number_format($item->quantidade, 2, '.', '');
            $std->vUnTrib = number_format($item->valor_unitario, 2, '.', '');
            $std->vUnCom = number_format($item->valor_unitario, 2, '.', '');
            $std->vProd = number_format($std->qCom * $std->vUnCom, 2, '.', '');
            $std->cEAN  = $std->cEANTrib = (!empty($item->product->codigo_barras)) ? $item->product->codigo_barras : 'SEM GTIN';
            $std->vDesc = ($item->desconto > 0) ? $item->desconto : null;
            $std->indTot = 1;

            $total_item = $std->vProd - $std->vDesc;

            if ($std->vDesc > 0) {
                $std->vDesc = number_format($std->vDesc, 2, '.', '');
                $this->total_desconto += $std->vDesc;
            }
            $this->total_items += $std->vProd;


            $this->nfe->tagprod($std);

            $std = new \stdClass();
            $std->item = $i;
            $this->nfe->tagimposto($std);

            if ($this->emitente->crt == 1) { //simples nacional

                if ($item->cst_icms == '102') {
                    $std = new \stdClass();
                    $std->item = $i;
                    $std->orig = $item->product->origem;
                    $std->CSOSN = '102';
                    $this->nfe->tagICMSSN($std);
                } else {
                    $std = new \stdClass();
                    $std->item = $i;
                    $std->orig = $item->product->origem;
                    $std->CSOSN = $item->cst_icms;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);

                    $this->total_BC += $total_item;
                    $this->total_ICMS += $std->vICMS;

                    $this->nfe->tagICMSSN($std);
                }

                $std = new \stdClass();
                $std->item = $i;
                $std->cEnq = ($item->cst_ipi == "52" || $item->cst_ipi == "53") ? '301' : '999';
                $std->CST = $item->cst_ipi;
                $std->vBC = $total_item;
                $std->pIPI = $item->p_ipi;
                $std->vIPI = $std->vBC * ($std->pIPI / 100);

                $this->total_IPI += $std->vIPI;
                $this->nfe->tagIPI($std);

                //PIS - Programa de Integração Social]
                $std = new \stdClass();
                $std->item = $i; //produtos 1
                $std->CST = $item->cst_pis;
                $std->vBC = $total_item;
                $std->pPIS = $item->p_pis;
                $std->vPIS = $std->vBC * ($std->pPIS / 100);

                $this->total_PIS += $std->vPIS;
                $this->nfe->tagPIS($std);

                //COFINS - Contribuição para o Financiamento da Seguridade Social
                $std = new \stdClass();
                $std->item = $i; //produtos 1
                $std->CST = $item->cst_cofins;
                $std->vBC = $total_item;
                $std->pCOFINS = $item->p_cofins;
                $std->vCOFINS = $std->vBC * ($std->pCOFINS / 100);

                $this->total_COFINS += $std->vCOFINS;
                $this->nfe->tagCOFINS($std);
            } else {
                // icms//
                $std = new \stdClass();
                $std->item = $i;
                $std->orig = $item->product->origem;
                $std->CST = $item->cst_icms;

                if ($item->cst_icms == "00") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                } elseif ($item->cst_icms == "10") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->cst_icms == "20") {
                    $std->modBC = 3;
                    $std->pRedBC = 0;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                } elseif ($item->cst_icms == "30") {
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->cst_icms == "40") {
                } elseif ($item->cst_icms == "41") {
                    $std->vBCSTRet = 0.00;
                    $std->vICMSSTRet = 0.00;
                } elseif ($item->cst_icms == "50") {
                } elseif ($item->cst_icms == "51") {
                } elseif ($item->cst_icms == "60") {
                    $std->vBCSTRet = 0.00;
                    $std->vICMSSTRet = 0.00;
                } elseif ($item->cst_icms == "70") {
                    $std->modBC = 3;
                    $std->vBC = $total_item;
                    $std->pICMS = $item->p_icms;
                    $std->vICMS = $std->vBC * ($std->pICMS / 100);
                    $this->total_ICMS += $std->vICMS;
                    $std->modBCST = 3;
                    $std->pMVAST = 10;
                    $std->vBCST = 0.00;
                    $std->pICMSST = 0.00;
                    $std->vICMSST = 0.00;
                } elseif ($item->cst_icms == "90") {
                }

                $this->nfe->tagICMS($std);

                //IPI
                $std = new \stdClass();
                $std->item = $i; //item da NFe
                $std->clEnq = null;
                $std->CNPJProd = null;
                $std->cSelo = null;
                $std->qSelo = null;
                $std->cEnq = '999';
                if ($item->cst_ipi == "52" || $item->cst_ipi == "53") {
                    $std->cEnq = '301';
                }
                $std->CST = $item->cst_ipi;
                $std->vBC = $total_item;
                $std->pIPI = $item->p_ipi;
                $std->vIPI = $std->vBC * ($std->pIPI / 100);
                $this->total_IPI += $std->vIPI;
                $std->qUnid = null;
                $std->vUnid = null;

                $this->nfe->tagIPI($std);

                //pis
                $std = new \stdClass();
                $std->item = $i; //item da NFe
                $std->CST = $item->cst_pis;
                $std->vBC = $total_item;
                $std->pPIS = $item->p_pis;
                $std->vPIS = $std->vBC * ($std->pPIS / 100);
                $this->total_PIS += $std->vPIS;
                $std->qBCProd = null;
                $std->vAliqProd = null;

                $this->nfe->tagPIS($std);


                $std = new \stdClass();
                $std->item = $i; //item da NFe
                $std->CST = $item->cst_cofins;
                $std->vBC = $total_item;
                $std->pCOFINS = $item->p_cofins;
                $std->vCOFINS = $std->vBC * ($std->pCOFINS / 100);
                $this->total_COFINS += $std->vCOFINS;
                $std->qBCProd = null;
                $std->vAliqProd = null;

                $this->nfe->tagCOFINS($std);
            }
        }

        $std = new \stdClass();
        $std->vBC = $this->total_BC;
        $std->vICMS = $this->total_ICMS;
        $std->vICMSDeson = "0.00";
        $std->vFCP = "0.00"; //incluso no layout 4.00
        $std->vBCST = "0.00";
        $std->vST = "0.00";
        $std->vFCPST = "0.00"; //incluso no layout 4.00
        $std->vFCPSTRet = "0.00"; //incluso no layout 4.00
        $std->vProd = $this->total_items;
        $std->vFrete = "0.00";
        $std->vSeg = "0.00";
        $std->vDesc = $this->total_desconto;
        $std->vII = "0.00";
        $std->vIPI = $this->total_IPI;
        $std->vIPIDevol = "0.00"; //incluso no layout 4.00
        $std->vPIS = $this->total_PIS;
        $std->vCOFINS = $this->total_COFINS;
        $std->vOutro = "0.00";
        $std->vNF = $this->total_items - $this->total_desconto;
        $std->vTotTrib = "0.00";

        $this->nfe->tagICMSTot($std);
    }

    private function gen_transporte()
    {
        if ($this->modelo != 55) {
            $std = new \stdClass();
            $std->modFrete = 9;
            $this->nfe->tagtransp($std);

            return;
        }

        $std = new \stdClass();
        $std->modFrete = $this->dados->modFrete;
        $this->nfe->tagtransp($std);

        if ($std->modFrete != 9) {
            $std = new \stdClass();
            $std->xNome = $this->dados->transp_nome;
            $std->IE = $this->dados->transp_ie;
            $std->xEnder = $this->dados->transp_address;
            $std->xMun = $this->dados->transp_cidade;
            $std->UF = $this->dados->transp_uf;

            if (strlen($this->dados->transp_cnpj) > 11) {
                $std->CNPJ = $this->dados->transp_cnpj; //só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            } else {
                $std->CPF = $this->dados->transp_cnpj;
            }

            $this->nfe->tagtransporta($std);

            $std = new \stdClass();
            $std->placa = $this->dados->veiculo_placa ?? null;
            $std->UF = $this->dados->veiculo_uf ?? null;
            $std->RNTC = $this->dados->veiculo_rntc ?? null;

            $this->nfe->tagveicTransp($std);

            $std = new \stdClass();
            $std->item = 1; //indicativo do numero do volume
            $std->qVol = $this->dados->volume_qVol ?? null;
            $std->esp = $this->dados->volume_esp ?? null;
            $std->marca = $this->dados->volume_marca ?? null;
            $std->nVol = $this->dados->volume_nVol ?? null;
            $std->pesoL = $this->dados->volume_pesoL ?? null;
            $std->pesoB = $this->dados->volume_pesoB ?? null;

            $this->nfe->tagvol($std);
        }
    }

    private function gen_payments()
    {

        $total_pago = 0;
        foreach ($this->payments as $payment) {
            $total_pago += floatval($payment->valor_pago);
        }


        $std = new \stdClass();
        $std->vTroco = $total_pago - ($this->total_items - $this->total_desconto);

        $this->nfe->tagpag($std);

        foreach ($this->payments as $payment) {
            $std = new \stdClass();

            // if ($payment->forma == "Dinheiro") {
            //     $std->indPag = '1';
            //     $std->tPag = '01';
            //     $std->vPag = $payment->valor_pago;
            // } else {
            //     $std->indPag = '1';
            //     $std->tPag = '99';
            //     $std->vPag = $payment->valor_pago;
            // }
            $std->indPag = '1';
            $std->tPag = $payment->pay->id_sefaz;
            $std->vPag = $payment->valor_pago;

            $this->nfe->tagdetPag($std);
        }

        $std = new \stdClass();
        $this->nfe->taginfNFeSupl($std);
    }

    /**
     * Constrói o XML.
     *
     * @return mixed
     */
    public function make($dados)
    {
        $this->dados = $dados;
        $this->items = $dados->itens;
        $this->payments = $dados->pagamentos;
        $this->references = $dados->references;

        $this->nfe = new Make();

        //cabeçalho da nota
        $this->gen_IDE();

        //emitente
        $this->get_Emitente();

        //destinatario
        $this->gen_Destinatario();

        //itens da nota
        if ($this->modelo == 55) {
            $this->gen_itens_nfe();
        } else {
            $this->gen_itens_nfce();
        }

        //transportes
        $this->gen_transporte();

        //pagamentos
        $this->gen_payments();

        if (isset($this->dados->infCpl)) {
            //informações adicionais
            $std = new \stdClass();
            // $std->infAdFisco = 'informacoes para o fisco';
            $std->infCpl = $this->dados->infCpl;
            $this->nfe->taginfAdic($std);
        }


        try {
            $this->xml = $this->nfe->getXml();

            file_put_contents('./nfe.xml', $this->xml);

            $this->mes = date('Y-m');

            $this->pathGerados .= "/{$this->mes}";

            Storage::disk('public')->put("{$this->pathGerados}/{$this->chave}.xml", $this->xml);

            return $this->sign_nota();

            return $this->xml;
        } catch (\Exception $e) {
            $erros = $this->nfe->getErrors();
            array_push($erros, $e->getMessage());
            return ['erros' => $erros];
        }
    }


    //assinatura
    private function sign_nota()
    {
        try {
            $this->xml = $this->tools->signNFe($this->xml);

            file_put_contents("nfe.xml", $this->xml);

            // $path = "xml/{$this->emitente->cnpj}/nfe/gerados/{$this->mesPath}/{$this->tpambPath}/{$this->chave}.xml";
            Storage::disk('public')->put("{$this->pathGerados}/{$this->chave}.xml", $this->xml);

            return $this->send_nota();

            return $this->xml;
        } catch (\Exception $e) {
            return array('erros' => [$e->getMessage()]);
        }
    }

    //envio do xml
    private function send_nota()
    {
        try {
            $idLote = str_pad(100, 15, '0', STR_PAD_LEFT); // Identificador do lote
            $resp = $this->tools->sefazEnviaLote([$this->xml], $idLote);

            $stdCl    = new Standardize($resp);
            $std      = $stdCl->toStd();

            if ($std->cStat != 103) {
                //erro registrar e voltar
                return ["erros" => array("$std->cStat - $std->xMotivo")];
            }

            $this->recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota

            $result = [];
            for ($i = 0; $i <= 3; $i++) { // loop de consulta

                $result = $this->consultarRecibo();

                if (isset($result['erros'])) {
                    break;
                }

                if ($result['cstatus'] == '103' || $result['cstatus'] == '105') {
                    sleep(3);
                    continue;
                }

                break;
            }

            // if ($result['cstatus'] == '103' || $result['cstatus'] == '105') { //x2
            //     sleep(3);
            //     $result = $this->consultarRecibo();

            //     if ($result['cstatus'] == '103' || $result['cstatus'] == '105') { //x3
            //         sleep(3);
            //         $result = $this->consultarRecibo();
            //         return $result;
            //     } else {
            //         return $result;
            //     }
            // } else {
            //     return $result;
            // }

            return $result;

            // return $std;
        } catch (\Exception $e) {
            //aqui você trata possiveis exceptions do envio
            return ["erros" => array($e->getMessage())];
        }
    }

    //consultar recibo
    public function consultarRecibo()
    {
        try {
            $response = $this->tools->sefazConsultaRecibo($this->recibo);

            // TRATA O RETORNO
            $stdCl = new Standardize($response);
            $std   = $stdCl->toStd();

            if ($std->cStat == '103') { //lote enviado
                //Lote ainda não foi precessado pela SEFAZ;
                return array('cstatus' => $std->cStat);
            }
            if ($std->cStat == '105') { //lote em processamento
                //tente novamente mais tarde
                return array('cstatus' => $std->cStat);
            }

            if ($std->cStat == '104') {

                if ($std->protNFe->infProt->cStat == '100') {
                    $xml = Complements::toAuthorize($this->xml, $response);

                    $cStatus = $std->protNFe->infProt->cStat;
                    $xMotivo = $std->protNFe->infProt->xMotivo;
                    $protocolo = $std->protNFe->infProt->nProt;

                    $this->pathAutorizados .= "/{$this->mes}";

                    $path = "{$this->pathAutorizados}/{$this->chave}.xml";

                    Storage::disk('public')->put($path, $xml);

                    return array(
                        'data_emissao' => $this->data_emissao,
                        'emitente_id' => $this->emitente->uuid,
                        'sequencia' => $this->numero,
                        'serie' => $this->serie,
                        'tipo_ambiente' => $this->tipo_ambiente,
                        'cstatus' => $cStatus,
                        'status' => $xMotivo,
                        'recibo' => $this->recibo,
                        'protocolo' => $protocolo,
                        'chave' => $this->chave
                    );
                } else {
                    return ["erros" => array("{$std->protNFe->infProt->cStat} - {$std->protNFe->infProt->xMotivo}")];
                }
            } else {
                return ["erros" => array("{$std->cStat} - {$std->xMotivo}")];
            }
        } catch (\Exception $e) {
            //aqui você trata possíveis exceptions da consulta
            return ["erros" => array($e->getMessage())];
        }
    }

    //consultar chave
    public function consultarChave($nota)
    {
        $chave = $nota->chave;
        $response = $this->tools->sefazConsultaChave($chave);

        $stdCl = new Standardize($response);
        $std = $stdCl->toStd();

        //verifique se o evento foi processado
        $cStat = $std->cStat;
        if ($cStat == '100' || $cStat == '101' || $cStat == '135' || $cStat == '155') {

            $nota->cstatus = $std->cStat;
            $nota->status = $std->xMotivo;

            return $nota;
        } else {
            //houve alguma falha no evento
            return ["erros" => ["{$std->cStat} - {$std->xMotivo}"]];
        }

        // return $std;
    }

    public function downloadXML($nota)
    {
        try {
            //este serviço somente opera em ambiente de produção
            $this->tools->setEnvironment(1);

            $chave = $nota->chave;
            $response = $this->tools->sefazDownload($chave);

            // header('Content-type: text/xml; charset=UTF-8');
            // echo $response;

        } catch (\Exception $e) {
            return ['errors' => [str_replace("\n", "<br/>", $e->getMessage())]];
        }
    }

    //cancela a nfe
    public function cancelarNFe($nota)
    {

        try {
            // $tools = new Tools($configJson, Certificate::readPfx($certificate, $business->senha_pfx));
            // $tools->model('55');

            $chave = $nota->chave;
            $xJust = $nota->xjust;
            $nProt = $nota->protocolo;
            $response = $this->tools->sefazCancela($chave, $xJust, $nProt);

            $stdCl = new Standardize($response);
            $std = $stdCl->toStd();

            //verifique se o evento foi processado
            if ($std->cStat != 128) {
                //houve alguma falha e o evento não foi processado
                return ["erros" => ["{$std->cStat} - {$std->xMotivo}"]];
            } else {
                $cStat = $std->retEvento->infEvento->cStat;
                if ($cStat == '101' || $cStat == '135' || $cStat == '155') {

                    $this->mes = date('Y-m', strtotime($nota->data_emissao));
                    $xmlAutorizado = Storage::disk('public')->get("{$this->pathAutorizados}/{$this->mes}/{$chave}.xml");

                    //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
                    $xml = Complements::cancelRegister($xmlAutorizado, $response);

                    //grave o XML protocolado
                    Storage::disk('public')->put("{$this->pathCancelados}/{$this->mes}/{$chave}.xml", $xml);

                    $nota->cstatus = $std->retEvento->infEvento->cStat;
                    $nota->status = $std->retEvento->infEvento->xMotivo;

                    return $nota;
                } elseif ($cStat == '573') {
                    $nota->cstatus = "573";
                    return $nota;
                } else {
                    //houve alguma falha no evento
                    return ["erros" => ["{$std->retEvento->infEvento->cStat} - {$std->retEvento->infEvento->xMotivo}"]];
                }
            }
        } catch (\Exception $e) {
            return ['erros' => [$e->getMessage()]];
        }
    }

    //gera o PDf
    public function geraPDF(object $dados)
    {
        $mes = date('Y-m', strtotime($dados->data_emissao));
        if ($dados->cstatus == 100) {
            $pathXML = "{$this->pathAutorizados}/{$mes}/{$dados->chave}.xml";
        } else {
            $pathXML = "{$this->pathCancelados}/{$mes}/{$dados->chave}.xml";
        }

        $docxml = Storage::disk('public')->get($pathXML);

        $logo =  "data://text/plain;base64," . base64_encode(Storage::disk('public')->get($this->emitente->logo));

        try {

            $danfe = new Danfe($docxml);
            $danfe->debugMode(false);
            $danfe->creditsIntegratorFooter('Powered by STORE FY');
            // $danfe->obsContShow(false);
            // $danfe->epec('891180004131899', '14/08/2018 11:24:45'); //marca como autorizada por EPEC
            // Caso queira mudar a configuracao padrao de impressao
            /*  $this->printParameters( $orientacao = '', $papel = 'A4', $margSup = 2, $margEsq = 2 ); */
            // Caso queira sempre ocultar a unidade tributável
            /*  $this->setOcultarUnidadeTributavel(true); */
            //Informe o numero DPEC
            /*  $danfe->depecNumber('123456789'); */
            //Configura a posicao da logo
            /*  $danfe->logoParameters($logo, 'C', false);  */

            //Gera o PDF
            $pdf = $danfe->render($logo);

            $filename = "temp/pdf/{$dados->chave}.pdf";
            Storage::disk('public')->put($filename, $pdf);

            return Storage::url($filename);
            // header('Content-Type: application/pdf');
            // echo $pdf;
        } catch (InvalidArgumentException $e) {
            return "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }



    public function monitorFiscal($ultNSU = 0)
    {
        //só funciona para o modelo 55
        $this->tools->model('55');
        //este serviço somente opera em ambiente de produção
        $this->tools->setEnvironment(1);

        //este numero deverá vir do banco de dados nas proximas buscas para reduzir
        //a quantidade de documentos, e para não baixar várias vezes as mesmas coisas.
        $maxNSU = $ultNSU;
        $loopLimit = 50;
        $iCount = 0;
        $find = false;

        //executa a busca de DFe em loop
        while ($ultNSU <= $maxNSU) {
            $iCount++;
            if ($iCount >= $loopLimit) {
                break;
            }
            try {
                //executa a busca pelos documentos
                $resp = $this->tools->sefazDistDFe($ultNSU);
            } catch (\Exception $e) {
                // echo $e->getMessage();
                //tratar o erro
                continue;
            }

            //extrair e salvar os retornos
            $dom = new \DOMDocument();
            $dom->loadXML($resp);
            $node = $dom->getElementsByTagName('retDistDFeInt')->item(0);
            // $tpAmb = $node->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            // $verAplic = $node->getElementsByTagName('verAplic')->item(0)->nodeValue;
            // $cStat = $node->getElementsByTagName('cStat')->item(0)->nodeValue;
            // $xMotivo = $node->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            // $dhResp = $node->getElementsByTagName('dhResp')->item(0)->nodeValue;
            $ultNSU = $node->getElementsByTagName('ultNSU')->item(0)->nodeValue;
            $maxNSU = $node->getElementsByTagName('maxNSU')->item(0)->nodeValue;
            $lote = $node->getElementsByTagName('loteDistDFeInt')->item(0);
            if (empty($lote)) {
                //lote vazio
                continue;
            }
            //essas tags irão conter os documentos zipados
            $docs = $lote->getElementsByTagName('docZip');
            foreach ($docs as $doc) {
                $numnsu = $doc->getAttribute('NSU');
                $schema = $doc->getAttribute('schema');
                //descompacta o documento e recupera o XML original
                $content = gzdecode(base64_decode($doc->nodeValue));
                //identifica o tipo de documento
                $tipo = substr($schema, 0, 6);
                //processar o conteudo do NSU, da forma que melhor lhe interessar
                //esse processamento depende do seu aplicativo

                if ($tipo == "resNFe") {
                    $stdCl = new Standardize($content);
                    $std   = $stdCl->toStd();

                    //variaveis
                    $dados = [
                        'emitente_id' => $this->emitente->uuid,
                        'nsu' => $numnsu,
                        'razao' => $std->xNome,
                        'cnpj' => $std->CNPJ,
                        'tipo_nota' => $std->tpNF,
                        'data' => $std->dhEmi,
                        'valor' => $std->vNF,
                        'chave' => $std->chNFe,
                        'nprot' => $std->nProt,
                        'csituacao' => $std->cSitNFe,
                    ];

                    if ($dados['csituacao'] == 1) {
                        $dados['status'] = 'Autorizada';
                        $dados['cstatus'] = 100;
                    } elseif ($dados['csituacao'] == 2) {
                        $dados['status'] = 'Uso Denegado';
                        $dados['cstatus'] = 200;
                    } elseif ($dados['csituacao'] == 3) {
                        $dados['status'] = 'Cancelada';
                        $dados['cstatus'] = 101;
                    }

                    $path = "{$this->pathMonitor}/resumos/{$numnsu}.xml";

                    Storage::disk('public')->put($path, $content);

                    $this->processMonitor($dados);
                    $find = true;
                }

                if ($tipo == "procNF") {
                    $stdCl = new Standardize($content);
                    $std   = $stdCl->toStd();

                    $chave = $std->protNFe->infProt->chNFe;

                    //variaveis
                    $dados = [
                        'emitente_id' => $this->emitente->uuid,
                        'nsu' => $numnsu,
                        'razao' => $std->NFe->infNFe->emit->xNome,
                        'cnpj' => $std->NFe->infNFe->emit->CNPJ,
                        'tipo_nota' => $std->NFe->infNFe->ide->tpNF,
                        'data' => $std->NFe->infNFe->ide->dhEmi,
                        'numero_nfe' => $std->NFe->infNFe->ide->nNF,
                        'valor' => $std->NFe->infNFe->total->ICMSTot->vNF,
                        'chave' => $std->protNFe->infProt->chNFe,
                        'nprot' => $std->protNFe->infProt->nProt,
                        'status' => $std->protNFe->infProt->xMotivo,
                        'cstatus' => $std->protNFe->infProt->cStat,
                    ];

                    $path = "{$this->pathMonitor}/notas/{$chave}.xml";

                    Storage::disk('public')->put($path, $content);

                    $this->processMonitor($dados);
                    $find = true;
                }
            }
            if ($ultNSU == $maxNSU) {
                $this->emitente->ultNSU = $maxNSU;
                $this->emitente->save();
                break; //CUIDADO para não deixar seu loop infinito !!
            }
            sleep(2);
        }

        return $find;
    }
    private function processMonitor($dados)
    {
        $result = MonitorFiscal::where('chave', $dados['chave'])->where('emitente_id', $dados['emitente_id'])->first();
        if (empty($result)) {
            $dados['uuid'] = Str::uuid();
            MonitorFiscal::create($dados);
        } else {
            $result->fill($dados);
            $result->save();
        }
    }

    public function manifestarNFe($params)
    {
        try {
            $this->tools->model('55');
            //este serviço somente opera em ambiente de produção
            $this->tools->setEnvironment(1);

            $chNFe = $params['chave']; //chave de 44 digitos da nota do fornecedor
            $tpEvento = $params['tpevento']; //ciencia da operação
            $xJust = isset($params['xjust']) ? $params['xjust'] : ''; //a ciencia não requer justificativa
            $nSeqEvento = $params['sequencia']; //a ciencia em geral será numero inicial de uma sequencia para essa nota e evento

            $response = $this->tools->sefazManifesta($chNFe, $tpEvento, $xJust = '', $nSeqEvento = 1);
            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário,
            //      quando houver a necessidade de protocolos
            $st = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $st->toStd();

            if ($std->cStat != 128) {
                return array('errors' => [$std->cStat . ' - ' . $std->xMotivo]);
            } else {

                $cStatus = $std->retEvento->infEvento->cStat;

                if ($cStatus == 135 || $cStatus == 573) {
                    $params['status'] = $std->retEvento->infEvento->xMotivo;

                    $params['cstatus'] = $std->retEvento->infEvento->cStat;

                    $params['evento'] = $std->retEvento->infEvento->xEvento;

                    // $params['nprot'] = $std->retEvento->infEvento->nProt;

                    $path = "{$this->pathMonitor}/eventos/{$chNFe}/{$nSeqEvento}-{$tpEvento}.xml";

                    Storage::disk('public')->put($path, $response);

                    return $this->processManifesta($params);
                } else {
                    return array('error' => [$std->retEvento->infEvento->cStat . ' - ' . $std->retEvento->infEvento->xMotivo]);
                }
            }
        } catch (\Exception $e) {
            return array('error' => $e->getMessage());
        }
    }
    private function processManifesta($dados)
    {
        $dados['uuid'] = Str::uuid();
        $import = MonitorFiscalEventos::create($dados);
        if (!$import->save()) {
            return array('error' => 'Falha ao salvar evento da nota');
        }

        return true;
    }

    public function downloadNFe($chave)
    {
        try {

            //só funciona para o modelo 55
            $this->tools->model('55');
            //este serviço somente opera em ambiente de produção
            $this->tools->setEnvironment(1);
            // $chave = '35180174283375000142550010000234761182919182';
            $response = $this->tools->sefazDownload($chave);

            $stz = new Standardize($response);
            $std = $stz->toStd();
            if ($std->cStat != 138) {
                return array('error' => "Documento não retornado. [$std->cStat] $std->xMotivo");
            }

            $zip = $std->loteDistDFeInt->docZip;
            $content = gzdecode(base64_decode($zip));

            $path = "{$this->pathMonitor}/notas/{$chave}.xml";

            Storage::disk('public')->put($path, $content);

            return $path;
        } catch (\Exception $e) {
            return array('error' => str_replace("\n", "<br/>", $e->getMessage()));
        }
    }

    /**
     * Pega o código do estado de acordo com a UF.
     *
     * @return int
     */
    private function _getStateCode($uf)
    {
        return $this->_statesCode[$uf];
    }
}
