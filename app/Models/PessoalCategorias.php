<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoalCategorias extends Model
{
    protected $table = 'pessoal_categorias';

    protected $fillable = [
        'nome', 
        'status', 
        'uuid', 
        'company_id',
    ];

    protected $hidden = ['id'];
}
