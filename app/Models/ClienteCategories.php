<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteCategories extends Model
{
    protected $table = 'clientes_categories';

    protected $fillable = [
        'nome', 
        'status', 
        'uuid', 
        'company_id',
    ];

    protected $hidden = ['id'];
}
