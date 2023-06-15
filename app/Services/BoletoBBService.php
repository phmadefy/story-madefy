<?php

namespace App\Services;

use App\Models\Boletos;
use App\Models\CfgBoletos;
use Carbon\Carbon;
use Eduardokum\LaravelBoleto\Boleto\Banco\Bb;
use Eduardokum\LaravelBoleto\Pessoa;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class BoletoBBService
{

    protected string $DATAFORMAT = 'd.m.Y';

    protected static array $DESCTIPOTITULO = [
        "1- CHEQUE",
        "2- DUPLICATA MERCANTIL",
        "3- DUPLICATA MTIL POR INDICACAO",
        "4- DUPLICATA DE SERVICO",
        "5- DUPLICATA DE SRVC P/INDICACAO",
        "6- DUPLICATA RURAL",
        "7- LETRA DE CAMBIO",
        "8- NOTA DE CREDITO COMERCIAL",
        "9- NOTA DE CREDITO A EXPORTACAO ",
        "10- NOTA DE CREDITO INDULTRIAL ",
        "11- NOTA DE CREDITO RURAL ",
        "12- NOTA PROMISSORIA ",
        "13- NOTA PROMISSORIA RURAL ",
        "14- TRIPLICATA MERCANTIL ",
        "15- TRIPLICATA DE SERVICO ",
        "16- NOTA DE SEGURO ",
        "17- RECIBO ",
        "18- FATURA ",
        "19- NOTA DE DEBITO ",
        "20- APOLICE DE SEGURO ",
        "21- MENSALIDADE ESCOLAR ",
        "22- PARCELA DE CONSORCIO ",
        "23- DIVIDA ATIVA DA UNIAO ",
        "24- DIVIDA ATIVA DE ESTADO ",
        "25- DIVIDA ATIVA DE MUNICIPIO ",
        "31- CARTAO DE CREDITO ",
        "32- BOLETO PROPOSTA ",
        "33- BOLETO APORTE ",
        "99- OUTROS",
    ];

    /*   function __construct($credentials) //1 - Prod | 2- Homolog
       {
           $this->client = new Client([
               // Base URI is used with relative requests
               'base_uri' => $credentials['tpAmb'] == 1 ? 'https://api.bb.com.br/cobranca/v2' : 'https://api.hm.bb.com.br/cobranca/v2',
               // You can set any number of default request options.
               // 'timeout'  => 2.0,
           ]);


       } */

    public function getOauthToken($cfg)
    {


        $tokenClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $cfg->producao ? $cfg->banco->oath_prod_path : $cfg->banco->oath_homolog_path,
            // You can set any number of default request options.
            // 'timeout'  => 2.0,
            'auth' => [$cfg->app_client, $cfg->app_secret]
        ]);

        $uri = 'oauth/token';

        $response = $tokenClient->request('POST', $uri, [
            'verify' => false,
            "form_params" => [
                'grant_type' => 'client_credentials',
                'scope' => 'cobrancas.boletos-requisicao+cobrancas.boletos-info'
            ]
        ]);

        $responseBody = $response->getBody()->getContents();

        return json_decode($responseBody)->access_token ?? NULL;

    }


    /**
     * @param Boletos $boleto
     * @param CfgBoletos $cfg
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function makeBoleto(Boletos $boleto, CfgBoletos $cfg)
    {

        try {


            if(!$cfg->producao){
                $boleto->numero = rand(999, 99999999);
                $boleto->save();
            }

            $nossoNumero = '000' . str_pad($cfg->convenio, 7, "0", STR_PAD_LEFT)
                . str_pad($boleto->numero, 10, "0", STR_PAD_LEFT);

            Log::info($nossoNumero);

            $pagador = $boleto->pagador;

            $dados = [
            "numeroConvenio" => $cfg->producao ? intval($cfg->convenio) : 3128557,
                "numeroCarteira" => $cfg->producao ? intval($cfg->carteira) : 17,
                "numeroVariacaoCarteira" => $cfg->producao ? (intval($cfg->variacao) ?? null) : 35,
                "codigoModalidade" => intval($cfg->modalidade) ?? null,
                "dataEmissao" => Carbon::parse($boleto->emissao)->format($this->DATAFORMAT),
                "dataVencimento" => Carbon::parse($boleto->vencimento)->format($this->DATAFORMAT),
                "valorOriginal" => floatval($boleto->valor),
                "valorAbatimento" => floatval($boleto->valorAbatimento) ?? null,
                "quantidadeDiasProtesto" => $cfg->diasProtesto ?? null,
                "quantidadeDiasNegativacao" => $cfg->quantidadeDiasNegativacao ?? null,
                "orgaoNegativador" => $cfg->orgaoNegativador ?? null,
                "indicadorAceiteTituloVencido" => $cfg->recebeTituloVencido ? 'S' : 'N',
                "numeroDiasLimiteRecebimento" => $cfg->diasLimiteRecebimento ?? null,
                "codigoAceite" => "N",
                "codigoTipoTitulo" => $cfg->codigoTipoTitulo ?? 4,
                "descricaoTipoTitulo" => "DUPLICATA DE SERVICO" ?? null,
                "indicadorPermissaoRecebimentoParcial" => $cfg->RecebimentoParcial ? 'N' : 'S',
                "numeroTituloBeneficiario" => $boleto->numero ?? null,
                "campoUtilizacaoBeneficiario" => $cfg->msgBoleto ?? null,
                "numeroTituloCliente" => $nossoNumero,
                "mensagemBloquetoOcorrencia" => "",
                "pagador" => [
                    "tipoInscricao" => $pagador->tipo == 1 ? 1 : 2,
                    "numeroInscricao" => $pagador->cpf,
                    "nome" => $pagador->nome,
                    "endereco" => $pagador->logradouro . ', ' . $pagador->numero,
                    "cep" => $pagador->cep,
                    "cidade" => $pagador->cidade,
                    "bairro" => $pagador->bairro,
                    "uf" => $pagador->uf,
                    "telefone" => $pagador->telefone
                ],
                "indicadorPix" => "N",
            ];

            if (!is_null($boleto->tipoDesconto1)) {
                $dados["desconto"] = [
                    "tipo" => 0,
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ];
            }

            if (!is_null($boleto->tipoDesconto2)) {
                $dados["segundoDesconto"] = [
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ];
            }

            if (!is_null($boleto->tipoDesconto3)) {
                $dados["terceiroDesconto"] = [
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ];
            }

            if ($cfg->tipoJurosMora != 0) {
                $dados["jurosMora"] = [
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ];
            }

            /*   "jurosMora" => [
               "tipo" => 0,
               "porcentagem" => 0,
               "valor" => 0
           ],
                   "multa" => [
               "tipo" => 0,
               "data" => "string",
               "porcentagem" => 0,
               "valor" => 0
           ], */

            if (!$token = $this->getOauthToken($cfg)) {
                return 'token_bb_invalido';
            }

            $client = new Client([
                // Base URI is used with relative requests
                //     'base_uri' => $cfg->producao ? $cfg->banco->path_prod : $cfg->banco->path_homolog,
                // You can set any number of default request options.
                // 'timeout'  => 2.0,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $uri = $cfg->banco->path_homolog . '/boletos?gw-dev-app-key=' . $cfg->app_key;

            $response = $client->request('POST', $uri, [
                'verify' => false,
                'body' => json_encode($dados)
            ]);

            $responseBody = json_decode($response->getBody()->getContents());

            $boleto->nossoNumero = $responseBody->numero;
            $boleto->linhaDigitavel = $responseBody->linhaDigitavel;
            $boleto->codigoBarraNumerico = $responseBody->codigoBarraNumerico;
            $boleto->agencia = $responseBody->beneficiario->agencia;
            $boleto->contaCorrente = $responseBody->beneficiario->contaCorrente;

            $boleto->save();

            return ['code' => 200];
        } catch (ClientException $e) {
            Log::info($e->getResponse()->getBody()->getContents());
            Log::info($e);
            return [
                'description' => $e->getResponse()->getBody()->getContents(),
                'code' => $e->getCode()
            ];
        } catch (\Exception $e) {
            Log::info('2: ' . $boleto->id);
            Log::info($e);
            return ['message' => $e->getMessage()];
        }
    }

    public function emitirBoleto($uuidBoleto, $uuidCfg = null)
    {
        $boleto = Boletos::where('uuid', '=', $uuidBoleto)->first() ?? null;

        if(is_null($boleto)){
            return response()->json('Boleto não encontrado', 500);
        }

        $cfg = is_null($uuidCfg) ?

            CfgBoletos::where('padrao', '=', TRUE)
                ->where('banco_id', '=', $boleto->banco_id)
                ->where('company_id', '=', $boleto->company_id)
                ->first() :

            CfgBoletos::where('uuid', '=', $uuidCfg)->first();

        return $this->makeBoleto($boleto, $cfg);

    }

    /**
     * @param Boletos $boleto
     * @return string
     * @throws \Throwable
     */

    public function printBoleto(Boletos $boleto)
    {

        $beneficiario = new Pessoa();
        $beneficiario
            ->setDocumento($boleto->emitente->cnpj)
            ->setNome($boleto->emitente->razao)
            ->setCep($boleto->emitente->cep)
            ->setEndereco($boleto->emitente->logradouro . ', ' . $boleto->emitente->numero)
            ->setBairro($boleto->emitente->bairro)
            ->setUf($boleto->emitente->uf)
            ->setCidade($boleto->emitente->cidade);

        $pagador = new Pessoa();
        $pagador
            ->setDocumento($boleto->pagador->cpf)
            ->setNome($boleto->pagador->nome)
            ->setCep($boleto->pagador->cep)
            ->setEndereco($boleto->pagador->logradouro . ', ' . $boleto->pagador->numero)
            ->setBairro($boleto->pagador->bairro)
            ->setUf($boleto->pagador->uf)
            ->setCidade($boleto->pagador->cidade);

        $cfg = $boleto->cfg;

        $nossoNumero = '000' . str_pad($cfg->convenio, 7, "0", STR_PAD_LEFT)
            . str_pad($boleto->numero, 10, "0", STR_PAD_LEFT);

        $bb = new Bb();
        $bb
            // ->setLogo('/path/to/logo.png')
            ->setDataVencimento(Carbon::parse($boleto->vencimento))
            ->setValor($boleto->valor)
            ->setNumero($boleto->numero)
            ->setNumeroDocumento($nossoNumero)
            ->setPagador($pagador)
            ->setBeneficiario($beneficiario)
            ->setCarteira($cfg->carteira)
            ->setAgencia($boleto->agencia)
            ->setConvenio($cfg->convenio)
            ->setConta($boleto->contaCorrente)
            ->setDescricaoDemonstrativo([$cfg->demonstrativo1, $cfg->demonstrativo2, $cfg->demonstrativo3])
            ->setInstrucoes([$cfg->instrucao1, $cfg->instrucao2, $cfg->instrucao3]);

//        $bb->addDescricaoDemonstrativo('demonstrativo 4');
        //      $bb->addInstrucoes('instrucao 2');

        return $bb->renderHTML(true);
    }
}
