<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContaCategoria extends Model
{
    protected $table = 'finance_contas_categorias';

    protected $fillable = [
        'nome', 'status', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
