<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFeImport extends Model
{
    protected $table = 'nfe_imports';

    protected $fillable = [
        'chave', 'numero_nfe', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
