<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoItem extends Model
{
    protected $table = 'contratos_itens';

    protected $fillable = [
        'tipo_produto', 'produto', 'quantidade', 'valor_custo', 'valor_unitario', 'desconto', 'total', 'uuid', 'contrato_id', 'produto_id',
    ];

    protected $hidden = ['id'];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'uuid', 'produto_id');
    }
}
