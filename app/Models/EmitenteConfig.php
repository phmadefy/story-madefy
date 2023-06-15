<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmitenteConfig extends Model
{
    protected $table = 'emitentes_config';

    protected $fillable = [
        'modelo', 'sequencia', 'sequencia_homolog', 'serie', 'serie_homolog', 'tipo_nota', 'tipo_emissao', 'tipo_impressao',
        'tipo_ambiente', 'csc', 'csc_id', 'csc_homolog', 'csc_id_homolog', 'uuid', 'emitente_id',
    ];

    protected $hidden = ['id'];
}
