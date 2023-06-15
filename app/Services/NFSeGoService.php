<?php

namespace App\Services;

use App\Models\Aliquotas;
use App\Models\Contrato;
use App\Models\Emitente;
use App\Models\FiscalNFSe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use NFePHP\Common\Certificate;
use NFePHP\NFSeAmtec\Common\FakePretty;
use NFePHP\NFSeAmtec\Common\Soap\SoapCurl;
use NFePHP\NFSeAmtec\Rps;
use NFePHP\NFSeAmtec\Tools;

class NFSeGoService
{
    protected $xml;

    protected $tools;
    protected $soap;
    protected $rps;
    protected $emitente;
    protected $pathRoot;
    protected $pathModelo;
    protected $pathAmbiente;
    protected $pathAutorizados;
    protected $pathCancelados;
    protected $pathGerados;
    protected $tipo_ambiente;
    protected $numero;
    protected $serie;


    function __construct(Emitente $emitente)
    {
        $this->emitente = $emitente;
        $this->pathRoot = "{$emitente->company_id}/XML/{$emitente->cnpj}";

        if (isset($emitente->config)) {
            $this->pathModelo = "NFSe/GO";
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
            'cnpj' => $this->emitente->cnpj,
            'im' => $this->emitente->inscricao_municipal,
            'cmun' => $this->emitente->ibge, // Goiânia não segue a tabela nacional IBGE Usar ( ./Municipios_SETEC_22.04.2013.txt )
            'razao' => $this->emitente->razao,
            'tpamb' => (int)$this->tipo_ambiente
        ];

        $configJson = json_encode($config);

        try {
            $pfx_content = Storage::disk('public')->get($emitente->file_pfx);
            $certificate = Certificate::readPfx($pfx_content, $emitente->senha_pfx);

            $this->soap = new SoapCurl($certificate);

            $this->tools = new Tools($configJson, $certificate);
            $this->tools->loadSoapClass($this->soap);
        } catch (\Exception $e) {
            throw $e;
        }

        // $this->tools->model($modelo);
    }

    /**
     * Constrói o XML.
     *
     * @return mixed
     */
    public function make(Contrato $dados)
    {
        try {

            $std = new \stdClass();
            $std->naturezaOperacao = 1;
            $std->regimeEspecialTributacao = 1;
            $std->optanteSimplesNacional = 2;
            $std->incentivadorCultural = 2;
            $std->version = '2.00'; //indica qual JsonSchema USAR na validação

            $numero = FiscalNFSe::where('emitente_id', '=', $this->emitente->uuid)
                    ->where('status', '=', true)
                    ->where('producao', '=', $this->emitente->config->tipo_ambiente == 1)
                    ->orderBy('numero', 'desc')
                    ->first()['numero'] ?? $this->numero;

            $aliquota = Aliquotas::where('emitente_id', '=', $this->emitente->uuid)
                    ->where('referencia', '<=', Carbon::now()->toDateString())
                    ->orderBy('referencia', 'desc')->first()['aliquota'] ?? null;

            $std->IdentificacaoRps = new \stdClass();
            $std->IdentificacaoRps->Numero = $numero; //limite 15 digitos
            $std->IdentificacaoRps->Serie = $this->serie; //BH deve ser string numerico
            $std->IdentificacaoRps->Tipo = 1; //1 - RPS 2-Nota Fiscal Conjugada (Mista) 3-Cupom
            $std->DataEmissao = date('Y-m-d\TH:i:s'); //'2020-08-12T23:33:22';
            $std->Status = 1;  // 1 – Normal  2 – Cancelado

            $this->chave = "{$this->emitente->cnpj}{$this->emitente->inscricao_municipal}{$std->IdentificacaoRps->Tipo}{$std->IdentificacaoRps->Numero}";

            $std->Tomador = new \stdClass();
            if ($dados->cliente->tipo == 2) {
                $std->Tomador->Cnpj = $dados->cliente->cpf;
            } else {
                $std->Tomador->Cpf = $dados->cliente->cpf;
            }

            $std->Tomador->RazaoSocial = $dados->cliente->nome;

            $std->Tomador->Endereco = new \stdClass();
            $std->Tomador->Endereco->Endereco = $dados->cliente->logradouro;
            $std->Tomador->Endereco->Numero = $dados->cliente->numero ?? 'S/N';
            $std->Tomador->Endereco->Complemento = $dados->cliente->complemento ?? '';
            $std->Tomador->Endereco->Bairro = $dados->cliente->bairro;
            $std->Tomador->Endereco->CodigoMunicipio = '0025300';
            $std->Tomador->Endereco->Uf = $dados->cliente->uf;
            $std->Tomador->Endereco->Cep = $dados->cliente->cep;

            $std->Servico = new \stdClass();
            $std->Servico->ItemListaServico = '11.01';
            $std->Servico->CodigoTributacaoMunicipio = '620150100';
            $std->Servico->Discriminacao = 'Referente ao contrato: ' . $dados->uuid;
            $std->Servico->CodigoMunicipio = '0025300';


            $std->Servico->Valores = new \stdClass();
            $std->Servico->Valores->ValorServicos = floatval($dados->valor_contrato);

            if(!is_null($aliquota)){
                $std->Servico->Valores->Aliquota = $aliquota;
            }

            // $std->Servico->Valores->ValorDeducoes = 10.00;
            // $std->Servico->Valores->ValorPis = 10.00;
            // $std->Servico->Valores->ValorCofins = 10.00;
            // $std->Servico->Valores->ValorInss = 10.00;
            // $std->Servico->Valores->ValorIr = 10.00;
            // $std->Servico->Valores->ValorCsll = 10.00;
            // $std->Servico->Valores->IssRetido = 2;
            // $std->Servico->Valores->ValorIss = 10.00;
            // $std->Servico->Valores->OutrasRetencoes = 10.00;
            // $std->Servico->Valores->Aliquota = 5;
            // $std->Servico->Valores->DescontoIncondicionado = 10.00;
            // $std->Servico->Valores->DescontoCondicionado = 10.00;

            // $std->IntermediarioServico = new \stdClass();
            // $std->IntermediarioServico->RazaoSocial = 'INSCRICAO DE TESTE SIATU - D AGUA -PAULINO S';
            // $std->IntermediarioServico->Cnpj = '99999999000191';
            //$std->IntermediarioServico->Cpf = '12345678901';
            // $std->IntermediarioServico->InscricaoMunicipal = '8041700010';

            // $std->ConstrucaoCivil = new \stdClass();
            // $std->ConstrucaoCivil->CodigoObra = '1234';
            // $std->ConstrucaoCivil->Art = '1234';

            //     return $std;

            $this->rps = new Rps($std);

            $xml = $this->rps->render($std);

            file_put_contents('./nfse.xml', $xml);

            // return $xml;

            $this->mes = date('Y-m');

            $this->pathGerados .= "/{$this->mes}";

            $filename = "{$this->pathGerados}/{$this->chave}.xml";

            Storage::disk('public')->put($filename, $xml);

            //   $lote = rand(0, 9999);

            // return Storage::url($filename);

            $response = $this->tools->gerarNfse($this->rps);

            Log::info($response);

            return simplexml_load_string($response);

            // return FakePretty::prettyPrint($response, '');

            // return $this->xml;
        } catch (\Exception $e) {
            Log::info($e);
            $erros = [];
            array_push($erros, $e->getMessage());
            return $e;
        }
    }


    //consultar recibo
    public function consultarRPS()
    {
        try {
            $numero = 3032;
            $serie = 'UNICA';
            $tipo = 1;

            $response = $this->tools->consultarNfsePorRps($numero, $serie, $tipo);
            return FakePretty::prettyPrint($response, '');
        } catch (\Exception $e) {
            //aqui você trata possíveis exceptions da consulta
            return ["erros" => array($e->getMessage())];
        }
    }

    //cancela a nfe
    public function cancelarNFSe($nota)
    {

        try {
        } catch (\Exception $e) {
            return ['erros' => [$e->getMessage()]];
        }
    }

    //gera o PDf
    public function geraPDF(object $dados)
    {
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
