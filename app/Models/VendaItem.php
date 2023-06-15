<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    protected $table = 'vendas_itens';

    protected $fillable = [
        'produto', 
        'quantidade', 
        'valor_custo', 
        'valor_unitario', 
        'desconto', 
        'total', 
        'uuid', 
        'venda_id', 
        'produto_id',
    ];

    protected $hidden = ['id'];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'uuid', 'produto_id');
    }
}
