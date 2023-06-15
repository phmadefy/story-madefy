<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoPagamento extends Model
{
    protected $table = 'contratos_pagamentos';

    protected $fillable = [
        'forma', 
        'valor_pago', 
        'valor_resto', 
        'observacao', 
        'uuid', 
        'forma_id', 
        'contrato_id',
    ];

    protected $hidden = ['id'];

    public function pay()
    {
        return $this->hasOne('App\Models\FormaPagamento', 'uuid', 'forma_id');
    }
}
