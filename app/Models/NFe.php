<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFe extends Model
{
    protected $table = "fiscal_nfe";

    protected $fillable = [
        'natOpe', 'tpNF', 'idDest', 'finNFe', 'indFinal', 'indPres',
        'nome', 'fantasia', 'cnpj', 'inscricao_estadual', 'logradouro', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'cep', 'ibge', 'cPais', 'xPais',
        'modFrete', 'transp_nome', 'transp_cnpj', 'transp_ie', 'transp_address', 'transp_cidade', 'transp_uf',
        'veiculo_placa', 'veiculo_uf', 'veiculo_rntc', 'volume_qVol', 'volume_esp', 'volume_marca', 'volume_nVol', 'volume_pesoL', 'volume_pesoB',
        'infCpl', 'subtotal', 'desconto', 'total', 'serie', 'sequencia', 'tipo_ambiente', 'cstatus', 'status', 'chave', 'recibo', 'protocolo', 'xjust', 'data_emissao',
        'uuid', 'company_id', 'emitente_id', 'cliente_id', 'venda_id',
    ];

    protected $hidden = [
        'id'
    ];

    public function itens()
    {
        return $this->hasMany('App\Models\NFeItens', 'nota_id', 'uuid');
    }

    public function pagamentos()
    {
        return $this->hasMany('App\Models\NFePagamentos', 'nota_id', 'uuid');
    }

    public function references()
    {
        return $this->hasMany('App\Models\NFeReferences', 'nota_id', 'uuid');
    }
}
