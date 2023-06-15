<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitorFiscalEventos extends Model
{
    protected $table = 'monitor_fiscal_eventos';

    protected $fillable = [
        'sequencia', 'tpevento', 'evento', 'xjust', 'chave', 'nprot', 'cstatus', 'status', 'uuid', 'emitente_id',
    ];

    protected $hidden = ['id'];
}
