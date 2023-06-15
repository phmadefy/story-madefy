<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalNFSe extends Model
{
    protected $table = 'fiscal_nfse';

    protected $fillable = [
        'uuid', 'emitente_id', 'pagador_id', 'contrato_id', 'company_id', 'status', 'numero', 'codigoVerificacao', 'serie', 'producao', 'im',
        'aliquota'
    ];

    protected $hidden = ['id'];

    public function emitente(){
        return $this->belongsTo(Emitente::class, 'emitente_id', 'uuid');
    }

    public function pagador(){
        return $this->belongsTo(Cliente::class, 'pagador_id', 'uuid');
    }

    public function contrato(){
        return $this->belongsTo(Contrato::class, 'contrato_id', 'uuid');
    }
}
