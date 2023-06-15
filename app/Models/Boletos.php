<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Boletos
 * @package App\Models
 */

/**
 * @OA\Schema(
 *     description="Boletos model",
 *     title="Boletos model",
 *    required={},
 *     @OA\Xml(
 *         name="Boletos"
 *     )
 * )
 */
class Boletos extends Model
{

    /**
     * @OA\Property(
     *     description="Field name",
     *     title="field title",
     *      property="field name",
     * ),
     *
     * @OA\Property(
     *     description="Status",
     *     title="status",
     *     type="boolean",
     *     default=false,
     *      property="status",
     * ),
     * @OA\Property(
     *     description="Uuid",
     *     title="uuid",
     *      property="uuid",
     * ),
     */

    use SoftDeletes, HasObsDelTrait;

    protected $table = 'boletos';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['uuid',
        'emitente_id',
        'pagador_id',
        'banco_id',
        'cfgBoleto_id',
        'emissao',
        'vencimento',
        'valor',
        'valorAbatimento',
        'tipoDesconto1',
        'dataDesconto1',
        'qtdDesconto1',
        'tipoDesconto2',
        'dataDesconto2',
        'qtdDesconto2',
        'tipoDesconto3',
        'dataDesconto3',
        'qtdDesconto3',
        'estadoTitulo',
        'descricaoEstadoTitulo',
        'company_id',
        'nossoNumero',
        'linhaDigitavel',
        'codigoBarraNumerico',
        'agencia',
        'contaCorrente',
    ];

    public function cfg()
    {
        return $this->belongsTo(CfgBoletos::class, 'cfgBoleto_id', 'uuid');
    }

    public function emitente(){
        return $this->belongsTo(Emitente::class, 'emitente_id', 'uuid');
    }

    public function pagador(){
        return $this->belongsTo(Cliente::class, 'pagador_id', 'uuid');
    }

    public function banco(){
        return $this->belongsTo(Bancos::class, 'banco_id', 'codigo');
    }
}
