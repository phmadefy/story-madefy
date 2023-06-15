<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmitenteConfigNfs extends Model
{
    protected $table = 'emitentes_config_nfs';

    protected $fillable = [
        'sequencia', 
        'sequencia_homolog', 
        'serie', 
        'serie_homolog', 
        'tipo',
        'tipo_ambiente',
        'uuid', 
        'emitente_id',
    ];

    protected $hidden = ['id'];
}
