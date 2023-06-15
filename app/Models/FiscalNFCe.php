<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalNFCe extends Model
{
    protected $table = 'fiscal_nfce';

    protected $fillable = [
        'nome', 'fantasia', 'cnpj', 'inscricao_estadual', 'logradouro', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'ibge',
        'subtotal', 'desconto', 'total', 'serie', 'sequencia', 'tipo_ambiente', 'cstatus', 'status', 'chave', 'recibo', 'protocolo',
        'xjust', 'data_emissao', 'uuid', 'emitente_id', 'cliente_id', 'venda_id', 'contrato_id',
    ];

    protected $hidden = ['id'];
}
