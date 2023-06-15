<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FornecedorCategories extends Model
{
    protected $table = 'fornecedores_categories';

    protected $fillable = [
        'nome', 
        'status', 
        'uuid', 
        'company_id',
    ];

    protected $hidden = ['id'];
}
