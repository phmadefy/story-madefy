<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportadoraCategories extends Model
{
    protected $table = 'transportadoras_categories';

    protected $fillable = [
        'nome', 
        'status', 
        'uuid', 
        'company_id',
    ];

    protected $hidden = ['id'];
}
