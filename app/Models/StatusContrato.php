<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusContrato extends Model
{
    use SoftDeletes;

    protected $table = 'statusContrato';
    public $timestamps = false;

    protected $fillable = [
       'descricao', 'codigo'
    ];

    public function contratos(){
        return $this->hasMany(Contrato::class, 'status_id');
    }

}
