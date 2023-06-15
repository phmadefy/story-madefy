<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaPagamento extends Model
{
    protected $table = 'vendas_pagamentos';

    protected $fillable = [
        'forma', 'valor_pago', 'valor_resto', 'observacao', 'uuid', 'forma_id', 'venda_id',
    ];

    protected $hidden = ['id'];

    public function pay()
    {
        return $this->hasOne('App\Models\FormaPagamento', 'uuid', 'forma_id');
    }
}
