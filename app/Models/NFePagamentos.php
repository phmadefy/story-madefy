<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFePagamentos extends Model
{
    protected $table = "fiscal_nfe_pagamentos";

    protected $fillable = [
        'forma', 'valor_pago', 'valor_resto', 'observacao', 'uuid', 'forma_id', 'nota_id',
    ];

    protected $hidden = [
        'id'
    ];

    public function pay()
    {
        return $this->hasOne('App\Models\FormaPagamento', 'uuid', 'forma_id');
    }
}
