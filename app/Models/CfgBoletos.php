<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class CfgBoletos
 * @package App\Models
 */

/**
 * @OA\Schema(
 *     description="CfgBoletos model",
 *     title="CfgBoletos model",
 *    required={},
 *     @OA\Xml(
 *         name="CfgBoletos"
 *     )
 * )
 */
class CfgBoletos extends Model
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

    protected $table = 'boletos_cfg';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'emitente_id',
        'banco_id',
        'app_key',
        'app_client',
        'app_secret',
        'convenio',
        'carteira',
        'variacao',
        'modalidade',
        'msgBoleto',
        'diasProtesto',
        'recebeTituloVencido',
        'diasLimiteRecebimento',
        'codigoAceite',
        'codigoTipoTitulo',
        'descricaoTipoTitulo',
        'RecebimentoParcial',
        'tipoJurosMora',
        'porcentagemJurosMora',
        'valorJurosMora',
        'tipoMulta',
        'diasInicioMulta',
        'porcentagemMulta',
        'valorMulta',
        'quantidadeDiasNegativacao',
        'orgaoNegativador',
        'producao',
        'padrao',
        'uuid',
        'company_id',
        'demonstrativo1',
        'demonstrativo2',
        'demonstrativo3',
        'instrucao1',
        'instrucao2',
        'instrucao3',
    ];

    public function boletos(){
        return $this->hasMany(Boletos::class, 'cfgBoleto_id');
    }

    public function emitente(){
        return $this->belongsTo(Emitente::class, 'emitente_id');
    }

    public function banco(){
        return $this->belongsTo(Bancos::class, 'banco_id', 'codigo');
    }
}
