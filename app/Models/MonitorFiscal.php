<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitorFiscal extends Model
{
    protected $table = 'monitor_fiscal';

    protected $fillable = [
        'nsu', 'numero_nfe', 'razao', 'cnpj', 'tipo_nota', 'valor', 'chave', 'nprot', 'cstatus', 'status', 'csituacao', 'data', 'uuid', 'emitente_id',
    ];

    protected $hidden = ['id'];
}
