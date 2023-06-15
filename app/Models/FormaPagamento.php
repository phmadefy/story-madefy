<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'formas_pagamento';

    protected $fillable = [
        'forma', 'id_sefaz', 'parcelamento', 'max_parcelas', 'cliente_required', 'extend', 'observacao', 'status', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
