<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFeReferences extends Model
{
    protected $table = "fiscal_nfe_referencias";

    protected $fillable = [
        'numero_nota', 'chave', 'tipo', 'nota_id',
    ];
}
