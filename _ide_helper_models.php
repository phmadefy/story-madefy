<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Aliquotas
 *
 * @OA\Schema (
 *     description="Aliquotas model",
 *     title="Aliquotas model",
 *    required={},
 *     @OA\Xml(
 *         name="Aliquotas"
 *     )
 * )
 * @property int $id
 * @property string $uuid
 * @property string $referencia
 * @property string $emitente_id
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $valor
 * @property-read \App\Models\Emitente $emitente
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas newQuery()
 * @method static \Illuminate\Database\Query\Builder|Aliquotas onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliquotas whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|Aliquotas withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Aliquotas withoutTrashed()
 */
	class Aliquotas extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bancos
 *
 * @OA\Schema (
 *     description="Bancos model",
 *     title="Bancos model",
 *    required={},
 *     @OA\Xml(
 *         name="Bancos"
 *     )
 * )
 * @property int $codigo
 * @property string $descricao
 * @property string|null $path_homolog
 * @property string|null $path_prod
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $oath_homolog_path
 * @property string|null $oath_prod_path
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos newQuery()
 * @method static \Illuminate\Database\Query\Builder|Bancos onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos whereOathHomologPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos whereOathProdPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos wherePathHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bancos wherePathProd($value)
 * @method static \Illuminate\Database\Query\Builder|Bancos withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bancos withoutTrashed()
 */
	class Bancos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Boletos
 *
 * @OA\Schema (
 *     description="Boletos model",
 *     title="Boletos model",
 *    required={},
 *     @OA\Xml(
 *         name="Boletos"
 *     )
 * )
 * @property int $id
 * @property string $uuid
 * @property string $emitente_id
 * @property string $pagador_id
 * @property int $banco_id
 * @property string $cfgBoleto_id
 * @property string $emissao
 * @property string $vencimento
 * @property string $valor
 * @property string|null $valorAbatimento
 * @property string|null $tipoDesconto1
 * @property string|null $dataDesconto1
 * @property string|null $qtdDesconto1
 * @property string|null $tipoDesconto2
 * @property string|null $dataDesconto2
 * @property string|null $qtdDesconto2
 * @property string|null $tipoDesconto3
 * @property string|null $dataDesconto3
 * @property string|null $qtdDesconto3
 * @property string|null $estadoTitulo
 * @property string|null $descricaoEstadoTitulo
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $numero
 * @property string|null $nossoNumero
 * @property string|null $linhaDigitavel
 * @property string|null $codigoBarraNumerico
 * @property string|null $numeroContratoCobranca
 * @property string|null $agencia
 * @property string|null $contaCorrente
 * @property-read \App\Models\Bancos $banco
 * @property-read \App\Models\CfgBoletos $cfg
 * @property-read \App\Models\Emitente $emitente
 * @property-read \App\Models\Cliente $pagador
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos newQuery()
 * @method static \Illuminate\Database\Query\Builder|Boletos onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereAgencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereBancoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereCfgBoletoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereCodigoBarraNumerico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereContaCorrente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereDataDesconto1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereDataDesconto2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereDataDesconto3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereDescricaoEstadoTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereEmissao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereEstadoTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereLinhaDigitavel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereNossoNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereNumeroContratoCobranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos wherePagadorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereQtdDesconto1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereQtdDesconto2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereQtdDesconto3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereTipoDesconto1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereTipoDesconto2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereTipoDesconto3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereValorAbatimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boletos whereVencimento($value)
 * @method static \Illuminate\Database\Query\Builder|Boletos withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Boletos withoutTrashed()
 */
	class Boletos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Caixa
 *
 * @property int $id
 * @property int $tipo
 * @property string $description
 * @property string $valor
 * @property string $uuid
 * @property string|null $forma_id
 * @property string $forma
 * @property string|null $user_id
 * @property string|null $conta_id
 * @property string|null $receita_id
 * @property string|null $venda_id
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereContaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereFormaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereReceitaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caixa whereVendaId($value)
 */
	class Caixa extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Categorias
 *
 * @OA\Schema (
 *     description="Categorias model",
 *     title="Categorias model",
 *    required={},
 *     @OA\Xml(
 *         name="Categorias"
 *     )
 * )
 * @method static \Illuminate\Database\Eloquent\Builder|Categorias newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorias newQuery()
 * @method static \Illuminate\Database\Query\Builder|Categorias onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorias query()
 * @method static \Illuminate\Database\Query\Builder|Categorias withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Categorias withoutTrashed()
 */
	class Categorias extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CfgBoletos
 *
 * @OA\Schema (
 *     description="CfgBoletos model",
 *     title="CfgBoletos model",
 *    required={},
 *     @OA\Xml(
 *         name="CfgBoletos"
 *     )
 * )
 * @property int $id
 * @property string $emitente_id
 * @property int $banco_id
 * @property string|null $app_key
 * @property string|null $app_client
 * @property string|null $app_secret
 * @property string|null $convenio
 * @property string|null $carteira
 * @property string|null $variacao
 * @property string|null $modalidade
 * @property string|null $msgBoleto
 * @property int|null $diasProtesto
 * @property bool|null $recebeTituloVencido
 * @property int|null $diasLimiteRecebimento
 * @property bool|null $codigoAceite
 * @property string|null $codigoTipoTitulo
 * @property string|null $descricaoTipoTitulo
 * @property bool|null $RecebimentoParcial
 * @property string|null $tipoJurosMora
 * @property string|null $porcentagemJurosMora
 * @property string|null $valorJurosMora
 * @property string|null $tipoMulta
 * @property int|null $diasInicioMulta
 * @property string|null $porcentagemMulta
 * @property string|null $valorMulta
 * @property int|null $quantidadeDiasNegativacao
 * @property string|null $orgaoNegativador
 * @property bool $producao
 * @property bool $padrao
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $primeiroBoleto
 * @property-read \App\Models\Bancos $banco
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Boletos[] $boletos
 * @property-read int|null $boletos_count
 * @property-read \App\Models\Emitente $emitente
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos newQuery()
 * @method static \Illuminate\Database\Query\Builder|CfgBoletos onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos query()
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereAppClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereAppKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereBancoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereCarteira($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereCodigoAceite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereCodigoTipoTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereConvenio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereDescricaoTipoTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereDiasInicioMulta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereDiasLimiteRecebimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereDiasProtesto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereModalidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereMsgBoleto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereOrgaoNegativador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos wherePadrao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos wherePorcentagemJurosMora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos wherePorcentagemMulta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos wherePrimeiroBoleto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereProducao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereQuantidadeDiasNegativacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereRecebeTituloVencido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereRecebimentoParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereTipoJurosMora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereTipoMulta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereValorJurosMora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereValorMulta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CfgBoletos whereVariacao($value)
 * @method static \Illuminate\Database\Query\Builder|CfgBoletos withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CfgBoletos withoutTrashed()
 */
	class CfgBoletos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cliente
 *
 * @property int $id
 * @property int $tipo
 * @property string $nome
 * @property string|null $apelido
 * @property string|null $identidade
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $telefone_secondary
 * @property string|null $email
 * @property string|null $description
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClienteCategories|null $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contato[] $contatos
 * @property-read int|null $contatos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereApelido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereIdentidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereTelefoneSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUuid($value)
 */
	class Cliente extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClienteCategories
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteCategories whereUuid($value)
 */
	class ClienteCategories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property int $tipo
 * @property string $razao
 * @property string|null $fantasia
 * @property string|null $cnpj
 * @property string|null $inscricao_estadual
 * @property string|null $telefone
 * @property string|null $email
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string $uuid
 * @property int $modelo_negocio
 * @property string $data_expire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $logo_full
 * @property string|null $logo_min
 * @property string|null $cor
 * @property string|null $layout
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDataExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereFantasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereInscricaoEstadual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereModeloNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRazao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUuid($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Conta
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $documento
 * @property float $valor
 * @property string $vencimento
 * @property float $valor_pago
 * @property string|null $data_pago
 * @property string|null $historico
 * @property int $situacao
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property string|null $nota_id
 * @property string $cliente_id
 * @property \App\Models\Pessoal|null $cliente
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ReceitaCategoria|null $categoria
 * @method static \Illuminate\Database\Eloquent\Builder|Conta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereDataPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereHistorico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereSituacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereValorPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereVencimento($value)
 */
	class Conta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContaCategoria
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContaCategoria whereUuid($value)
 */
	class ContaCategoria extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contato
 *
 * @property int $id
 * @property string $nome
 * @property int $tipo_contato
 * @property string $contato
 * @property string|null $cliente_id
 * @property string|null $transportadora_id
 * @property string|null $fornecedor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contato newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contato newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contato query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereContato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereFornecedorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereTipoContato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereTransportadoraId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contato whereUpdatedAt($value)
 */
	class Contato extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contrato
 *
 * @property int $id
 * @property int $tipo_recorrencia
 * @property int $periodo_recorrencia
 * @property int|null $dia_faturamento
 * @property string|null $data_faturamento
 * @property int $emitir_nfse
 * @property int $emitir_nfe
 * @property int $gerar_financeiro
 * @property int $send_docs
 * @property string $valor_contrato
 * @property string|null $description
 * @property int $status_id
 * @property string $uuid
 * @property string|null $forma_pagamento
 * @property string $company_id
 * @property string $user_id
 * @property string|null $cliente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $vendedor_id
 * @property string|null $data_inicio_prestacao
 * @property string|null $numero_cliente
 * @property-read \App\Models\Cliente|null $cliente
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\FormaPagamento|null $formaPagamento
 * @property-read mixed $cliente_name
 * @property-read mixed $status
 * @property-read mixed $status_cod
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContratoItem[] $itens
 * @property-read int|null $itens_count
 * @property-read \App\Models\FiscalNFSe|null $nfse
 * @property-read \App\Models\StatusContrato $statusContrato
 * @property-read \App\Models\User|null $usuario
 * @property-read \App\Models\User|null $vendedor
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato newQuery()
 * @method static \Illuminate\Database\Query\Builder|Contrato onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereDataFaturamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereDataInicioPrestacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereDiaFaturamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereEmitirNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereEmitirNfse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereFormaPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereGerarFinanceiro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereNumeroCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato wherePeriodoRecorrencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereSendDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereTipoRecorrencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereValorContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrato whereVendedorId($value)
 * @method static \Illuminate\Database\Query\Builder|Contrato withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contrato withoutTrashed()
 */
	class Contrato extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContratoItem
 *
 * @property int $id
 * @property int $tipo_produto
 * @property string $produto
 * @property string $quantidade
 * @property string $valor_custo
 * @property string $valor_unitario
 * @property string $desconto
 * @property string $total
 * @property string $uuid
 * @property string $contrato_id
 * @property string|null $produto_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereContratoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereProduto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereQuantidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereTipoProduto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereValorCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoItem whereValorUnitario($value)
 */
	class ContratoItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContratoPagamento
 *
 * @property-read \App\Models\FormaPagamento|null $pay
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContratoPagamento query()
 */
	class ContratoPagamento extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Emitente
 *
 * @property int $id
 * @property int $ultNSU
 * @property int $tipo
 * @property int $crt
 * @property string $razao
 * @property string|null $fantasia
 * @property string|null $cnpj
 * @property string|null $inscricao_estadual
 * @property string|null $inscricao_municipal
 * @property string|null $telefone
 * @property string|null $email
 * @property string|null $email_contabil
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string|null $logo
 * @property string|null $file_pfx
 * @property string|null $senha_pfx
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Aliquotas[] $aliquitas
 * @property-read int|null $aliquitas_count
 * @property-read mixed $certificate_url
 * @property-read mixed $logo_url
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereCrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereEmailContabil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereFantasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereFilePfx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereInscricaoEstadual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereInscricaoMunicipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereRazao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereSenhaPfx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereUltNSU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emitente whereUuid($value)
 */
	class Emitente extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmitenteConfig
 *
 * @property int $id
 * @property int $modelo
 * @property int $sequencia
 * @property int $sequencia_homolog
 * @property string $serie
 * @property string $serie_homolog
 * @property int $tipo_nota
 * @property int $tipo_emissao
 * @property int $tipo_impressao
 * @property int $tipo_ambiente
 * @property string|null $csc
 * @property string|null $csc_id
 * @property string|null $csc_homolog
 * @property string|null $csc_id_homolog
 * @property string $uuid
 * @property string $emitente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $bloqueado
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereBloqueado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereCsc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereCscHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereCscId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereCscIdHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereModelo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereSequenciaHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereSerieHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereTipoAmbiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereTipoEmissao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereTipoImpressao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereTipoNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfig whereUuid($value)
 */
	class EmitenteConfig extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmitenteConfigNfs
 *
 * @property int $id
 * @property string $uuid
 * @property int $tipo
 * @property int $tipo_ambiente
 * @property int $sequencia
 * @property int $sequencia_homolog
 * @property string $serie
 * @property string $serie_homolog
 * @property string $emitente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $bloqueado
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereBloqueado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereSequenciaHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereSerieHomolog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereTipoAmbiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmitenteConfigNfs whereUuid($value)
 */
	class EmitenteConfigNfs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FiscalNFCe
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $fantasia
 * @property string|null $cnpj
 * @property string|null $inscricao_estadual
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property string $subtotal
 * @property string $desconto
 * @property string $total
 * @property int $serie
 * @property int $sequencia
 * @property int $tipo_ambiente
 * @property int $cstatus
 * @property string $status
 * @property string $chave
 * @property string|null $recibo
 * @property string|null $protocolo
 * @property string|null $xjust
 * @property string|null $data_emissao
 * @property string $uuid
 * @property string|null $emitente_id
 * @property string|null $cliente_id
 * @property string|null $venda_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe query()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereCstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereDataEmissao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereFantasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereInscricaoEstadual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereProtocolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereRecibo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereTipoAmbiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereVendaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFCe whereXjust($value)
 */
	class FiscalNFCe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FiscalNFSe
 *
 * @property int $id
 * @property string $uuid
 * @property string $emitente_id
 * @property string $pagador_id
 * @property string $contrato_id
 * @property int $numero
 * @property string $serie
 * @property string $im
 * @property bool $producao
 * @property string $codigoVerificacao
 * @property bool $status
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $aliquota_id
 * @property-read \App\Models\Contrato $contrato
 * @property-read \App\Models\Emitente $emitente
 * @property-read \App\Models\Cliente $pagador
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe query()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereAliquotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereCodigoVerificacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereContratoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereIm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe wherePagadorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereProducao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalNFSe whereUuid($value)
 */
	class FiscalNFSe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FormaPagamento
 *
 * @property int $id
 * @property string $forma
 * @property string $id_sefaz
 * @property int $parcelamento
 * @property int $max_parcelas
 * @property int $cliente_required
 * @property int $extend
 * @property string|null $observacao
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereClienteRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereExtend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereIdSefaz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereMaxParcelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereParcelamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereUuid($value)
 */
	class FormaPagamento extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fornecedor
 *
 * @property int $id
 * @property int $tipo
 * @property string $nome
 * @property string|null $apelido
 * @property string|null $identidade
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $telefone_secondary
 * @property string|null $email
 * @property string|null $description
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FornecedorCategories|null $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contato[] $contatos
 * @property-read int|null $contatos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereApelido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereIdentidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereTelefoneSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fornecedor whereUuid($value)
 */
	class Fornecedor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FornecedorCategories
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FornecedorCategories whereUuid($value)
 */
	class FornecedorCategories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Galeria
 *
 * @property int $id
 * @property string $produto_id
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $produtos
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Galeria whereUpdatedAt($value)
 */
	class Galeria extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MonitorFiscal
 *
 * @property int $id
 * @property int $nsu
 * @property int $numero_nfe
 * @property string|null $razao
 * @property string|null $cnpj
 * @property int|null $tipo_nota
 * @property float|null $valor
 * @property string|null $chave
 * @property string|null $nprot
 * @property int|null $cstatus
 * @property string|null $status
 * @property int|null $csituacao
 * @property string $data
 * @property string $uuid
 * @property string $emitente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereCsituacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereCstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereNprot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereNsu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereNumeroNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereRazao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereTipoNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscal whereValor($value)
 */
	class MonitorFiscal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MonitorFiscalEventos
 *
 * @property int $id
 * @property int $sequencia
 * @property int $tpevento
 * @property string|null $evento
 * @property string|null $xjust
 * @property string|null $chave
 * @property string|null $nprot
 * @property int|null $cstatus
 * @property string|null $status
 * @property string $uuid
 * @property string $emitente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereCstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereEvento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereNprot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereTpevento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorFiscalEventos whereXjust($value)
 */
	class MonitorFiscalEventos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NFe
 *
 * @property int $id
 * @property string $natOpe
 * @property int $tpNF
 * @property int $idDest
 * @property int $finNFe
 * @property int $indFinal
 * @property int $indPres
 * @property string|null $nome
 * @property string|null $fantasia
 * @property string|null $cnpj
 * @property string|null $inscricao_estadual
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property string $cPais
 * @property string $xPais
 * @property int $modFrete
 * @property string|null $transp_nome
 * @property string|null $transp_cnpj
 * @property string|null $transp_ie
 * @property string|null $transp_address
 * @property string|null $transp_cidade
 * @property string|null $transp_uf
 * @property string|null $veiculo_placa
 * @property string|null $veiculo_uf
 * @property string|null $veiculo_rntc
 * @property string|null $volume_qVol
 * @property string|null $volume_esp
 * @property string|null $volume_marca
 * @property string|null $volume_nVol
 * @property string|null $volume_pesoL
 * @property string|null $volume_pesoB
 * @property string|null $infCpl
 * @property string $subtotal
 * @property string $frete
 * @property string $desconto
 * @property string $total
 * @property int $serie
 * @property int $sequencia
 * @property int $tipo_ambiente
 * @property int $cstatus
 * @property string $status
 * @property string $chave
 * @property string|null $recibo
 * @property string|null $protocolo
 * @property string|null $xjust
 * @property string|null $data_emissao
 * @property string $uuid
 * @property string $company_id
 * @property string|null $emitente_id
 * @property string|null $cliente_id
 * @property string|null $venda_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $contrato_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NFeItens[] $itens
 * @property-read int|null $itens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NFePagamentos[] $pagamentos
 * @property-read int|null $pagamentos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NFeReferences[] $references
 * @property-read int|null $references_count
 * @method static \Illuminate\Database\Eloquent\Builder|NFe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFe query()
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCPais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereContratoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereCstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereDataEmissao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereEmitenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereFantasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereFinNFe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereFrete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereIdDest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereIndFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereIndPres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereInfCpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereInscricaoEstadual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereModFrete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereNatOpe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereProtocolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereRecibo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTipoAmbiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTpNF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspIe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereTranspUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVeiculoPlaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVeiculoRntc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVeiculoUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVendaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumeEsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumeMarca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumeNVol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumePesoB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumePesoL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereVolumeQVol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereXPais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFe whereXjust($value)
 */
	class NFe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NFeImport
 *
 * @property int $id
 * @property string $chave
 * @property string $numero_nfe
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport query()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereNumeroNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeImport whereUuid($value)
 */
	class NFeImport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NFeItens
 *
 * @property int $id
 * @property string $produto
 * @property string|null $cEAN
 * @property string $quantidade
 * @property string $valor_custo
 * @property string $valor_unitario
 * @property string $desconto
 * @property string $total
 * @property string|null $unidade
 * @property string|null $cfop
 * @property string|null $ncm
 * @property string|null $cst_icms
 * @property string $p_icms
 * @property string|null $cst_ipi
 * @property string $p_ipi
 * @property string|null $cst_pis
 * @property string $p_pis
 * @property string|null $cst_cofins
 * @property string $p_cofins
 * @property string $uuid
 * @property string $nota_id
 * @property string|null $produto_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens query()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCEAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCfop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCstCofins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCstIcms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCstIpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereCstPis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereNcm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens wherePCofins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens wherePIcms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens wherePIpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens wherePPis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereProduto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereQuantidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereUnidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereValorCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeItens whereValorUnitario($value)
 */
	class NFeItens extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NFePagamentos
 *
 * @property int $id
 * @property string $forma
 * @property string $valor_pago
 * @property string $valor_resto
 * @property string|null $observacao
 * @property string $uuid
 * @property string $forma_id
 * @property string $nota_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormaPagamento|null $pay
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos query()
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereFormaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereValorPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFePagamentos whereValorResto($value)
 */
	class NFePagamentos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NFeReferences
 *
 * @property int $id
 * @property string $numero_nota
 * @property string $chave
 * @property int $tipo
 * @property string $nota_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences query()
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereChave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereNumeroNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NFeReferences whereUpdatedAt($value)
 */
	class NFeReferences extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pessoal
 *
 * @property int $id
 * @property int $tipo
 * @property string $nome
 * @property string|null $apelido
 * @property string|null $identidade
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $telefone_secondary
 * @property string|null $email
 * @property string|null $observacao
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PessoalCategorias|null $categoria
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereApelido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereIdentidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereTelefoneSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pessoal whereUuid($value)
 */
	class Pessoal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PessoalCategorias
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias query()
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PessoalCategorias whereUuid($value)
 */
	class PessoalCategorias extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $tipo
 * @property string $nome
 * @property string|null $codigo_barras
 * @property string|null $referencia
 * @property string $unidade
 * @property string $estoque_atual
 * @property string $valor_custo
 * @property string $margem
 * @property string $valor_venda
 * @property int $origem
 * @property string|null $ncm
 * @property string|null $cfop
 * @property string|null $cst_icms
 * @property string $p_icms
 * @property string|null $cst_ipi
 * @property string $p_ipi
 * @property string|null $cst_pis
 * @property string $p_pis
 * @property string|null $cst_cofins
 * @property string $p_cofins
 * @property int $status
 * @property string|null $foto
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $iss_retido
 * @property string $p_iss
 * @property-read \App\Models\ProductCategorias|null $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Galeria[] $fotos
 * @property-read int|null $fotos_count
 * @property-read mixed $foto_capa
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductMovimento[] $movimentos
 * @property-read int|null $movimentos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCfop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodigoBarras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCstCofins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCstIcms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCstIpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCstPis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEstoqueAtual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIssRetido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMargem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNcm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOrigem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePCofins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePIcms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePIpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePIss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePPis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValorCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValorVenda($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductCategorias
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategorias whereUuid($value)
 */
	class ProductCategorias extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductMovimento
 *
 * @property int $id
 * @property int $tipo
 * @property string $produto_id
 * @property string|null $user_id
 * @property string|null $venda_id
 * @property string $quantidade
 * @property string $valor_custo
 * @property string|null $nota_id
 * @property string|null $numero_nota
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereNumeroNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereQuantidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereValorCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovimento whereVendaId($value)
 */
	class ProductMovimento extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Receita
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $documento
 * @property float $valor
 * @property string $vencimento
 * @property float $valor_pago
 * @property string|null $data_pago
 * @property string|null $historico
 * @property int $situacao
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property string|null $venda_id
 * @property string $cliente_id
 * @property \App\Models\Pessoal|null $cliente
 * @property string $vendedor_id
 * @property \App\Models\Pessoal|null $vendedor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $contrato_id
 * @property bool $isBoleto
 * @property-read \App\Models\ReceitaCategoria|null $categoria
 * @property-read \App\Models\Contrato|null $contrato
 * @property-read \App\Models\Venda|null $venda
 * @method static \Illuminate\Database\Eloquent\Builder|Receita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Receita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Receita query()
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereContratoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereDataPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereHistorico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereIsBoleto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereSituacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereValorPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereVencimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereVendaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereVendedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receita whereVendedorId($value)
 */
	class Receita extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceitaCategoria
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceitaCategoria whereUuid($value)
 */
	class ReceitaCategoria extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StatusContrato
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contrato[] $contratos
 * @property-read int|null $contratos_count
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato newQuery()
 * @method static \Illuminate\Database\Query\Builder|StatusContrato onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusContrato whereId($value)
 * @method static \Illuminate\Database\Query\Builder|StatusContrato withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StatusContrato withoutTrashed()
 */
	class StatusContrato extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TiposCategoria
 *
 * @OA\Schema (
 *     description="TiposCategoria model",
 *     title="TiposCategoria model",
 *    required={},
 *     @OA\Xml(
 *         name="TiposCategoria"
 *     )
 * )
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property string $endPoint
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereEndPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TiposCategoria whereUpdatedAt($value)
 */
	class TiposCategoria extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transportadora
 *
 * @property int $id
 * @property int $tipo
 * @property string $nome
 * @property string|null $apelido
 * @property string|null $identidade
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $telefone_secondary
 * @property string|null $email
 * @property string|null $description
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $complemento
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $ibge
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property string|null $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TransportadoraCategories|null $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contato[] $contatos
 * @property-read int|null $contatos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereApelido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereIbge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereIdentidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereTelefoneSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportadora whereUuid($value)
 */
	class Transportadora extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TransportadoraCategories
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransportadoraCategories whereUuid($value)
 */
	class TransportadoraCategories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property int $status
 * @property string|null $permission_id
 * @property string $uuid
 * @property string|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $master
 * @property string|null $layout
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\UserPermission|null $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\UserPermission
 *
 * @property int $id
 * @property string $description
 * @property int $create_user
 * @property int $update_user
 * @property int $delete_user
 * @property int $create_permission
 * @property int $update_permission
 * @property int $delete_permission
 * @property int $create_pessoal
 * @property int $update_pessoal
 * @property int $delete_pessoal
 * @property int $create_product
 * @property int $update_product
 * @property int $delete_product
 * @property int $create_emitente
 * @property int $update_emitente
 * @property int $delete_emitente
 * @property int $create_payments
 * @property int $update_payments
 * @property int $delete_payments
 * @property int $create_sale
 * @property int $update_sale
 * @property int $delete_sale
 * @property int $create_monitor
 * @property int $update_monitor
 * @property int $delete_monitor
 * @property int $create_nfe
 * @property int $update_nfe
 * @property int $delete_nfe
 * @property int $create_caixa
 * @property int $update_caixa
 * @property int $delete_caixa
 * @property int $create_contas
 * @property int $update_contas
 * @property int $delete_contas
 * @property int $create_receitas
 * @property int $update_receitas
 * @property int $delete_receitas
 * @property string $uuid
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $pay_sale
 * @property int $desconto_sale
 * @property int $pay_contas
 * @property int $pay_receitas
 * @property int $create_contratos
 * @property int $update_contratos
 * @property int $pay_contratos
 * @property int $delete_contratos
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateCaixa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateContas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateContratos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateEmitente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateMonitor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatePayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatePessoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateReceitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreateUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteCaixa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteContas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteContratos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteEmitente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteMonitor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeletePayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeletePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeletePessoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteReceitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDeleteUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDescontoSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission wherePayContas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission wherePayContratos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission wherePayReceitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission wherePaySale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateCaixa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateContas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateContratos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateEmitente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateMonitor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateNfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatePayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatePessoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateReceitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdateUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUuid($value)
 */
	class UserPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Venda
 *
 * @property int $id
 * @property int $sequencia
 * @property string $cliente
 * @property string|null $cpf
 * @property string $subtotal
 * @property string $descontos
 * @property string $desconto
 * @property string $total
 * @property string $total_custo
 * @property string|null $description
 * @property int $status_id
 * @property string $status
 * @property string $uuid
 * @property string $company_id
 * @property string $user_id
 * @property string|null $cliente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VendaItem[] $itens
 * @property-read int|null $itens_count
 * @property-read \App\Models\FiscalNFCe|null $nfce
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VendaPagamento[] $pagamentos
 * @property-read int|null $pagamentos_count
 * @property-read \App\Models\User|null $vendedor
 * @method static \Illuminate\Database\Eloquent\Builder|Venda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venda query()
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereDescontos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereSequencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereTotalCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venda whereUuid($value)
 */
	class Venda extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VendaItem
 *
 * @property int $id
 * @property string $produto
 * @property string $quantidade
 * @property string $valor_custo
 * @property string $valor_unitario
 * @property string $desconto
 * @property string $total
 * @property string $uuid
 * @property string $venda_id
 * @property string|null $produto_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereDesconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereProduto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereQuantidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereValorCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereValorUnitario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaItem whereVendaId($value)
 */
	class VendaItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VendaPagamento
 *
 * @property int $id
 * @property string $forma
 * @property string $valor_pago
 * @property string $valor_resto
 * @property string|null $observacao
 * @property string $uuid
 * @property string $forma_id
 * @property string $venda_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormaPagamento|null $pay
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereFormaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereValorPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereValorResto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendaPagamento whereVendaId($value)
 */
	class VendaPagamento extends \Eloquent {}
}

