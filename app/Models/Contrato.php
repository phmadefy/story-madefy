<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use SoftDeletes;

    protected $table = 'contratos';

    protected $fillable = [
        'tipo_recorrencia', 'periodo_recorrencia', 'dia_faturamento', 'data_faturamento',
        'emitir_nfse', 'emitir_nfe', 'gerar_financeiro', 'send_docs', 'valor_contrato', 'description', 'status_id', 'uuid', 'forma_pagamento',
        'company_id', 'user_id', 'cliente_id', 'data_inicio_prestacao', 'vendedor_id', 'numero_cliente'
    ];

    protected $hidden = [];

    protected $appends = ['cliente_name', 'status', 'status_cod'];

    public function getClienteNameAttribute()
    {
        if (isset($this->attributes['cliente_id'])) {
            $res = Cliente::where('uuid', '=', $this->attributes['cliente_id'])->first();

            if (!empty($res)) {
                return $res->nome;
            }

            return '-';
        }
    }

    public function getStatusAttribute()
    {
        return $this->statusContrato->descricao;
    }

    public function getStatusCodAttribute()
    {
        return $this->statusContrato->codigo;
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'uuid', 'company_id');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Models\User', 'uuid', 'vendedor_id');
    }


    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'uuid', 'cliente_id');
    }

    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'uuid', 'user_id');
    }

    public function itens()
    {
        return $this->hasMany(ContratoItem::class, 'contrato_id', 'uuid');
    }

    public function nfe()
    {
        return $this->hasOne('App\Models\FiscalNFe', 'contrato_id', 'uuid');
    }

    public function nfse()
    {
        return $this->hasOne(FiscalNFSe::class, 'contrato_id', 'uuid');
    }

    public function statusContrato(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StatusContrato::class, 'status_id', 'id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento', 'uuid');
    }
}
