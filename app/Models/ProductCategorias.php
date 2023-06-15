<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategorias extends Model
{
    protected $table = 'produtos_categorias';

    protected $fillable = [
        'nome', 'status', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
