<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $fillable = [
        'nome', 'tipo_contato', 'contato', 'cliente_id', 'transportadora_id', 'fornecedor_id',
    ];
}
