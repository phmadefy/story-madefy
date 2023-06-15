<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceitaCategoria extends Model
{
    protected $table = 'finance_receitas_categorias';

    protected $fillable = [
        'nome', 'status', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
