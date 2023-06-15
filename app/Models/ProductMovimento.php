<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMovimento extends Model
{
    protected $table = 'produtos_movimentos';

    protected $fillable = [
        'tipo', 'produto_id', 'user_id', 'venda_id', 'quantidade', 'valor_custo', 'nota_id', 'numero_nota',
    ];

    protected $hidden = [];
}
