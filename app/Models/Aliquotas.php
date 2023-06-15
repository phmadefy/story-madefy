<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Aliquotas
 * @package App\Models
 */

 /**
  * @OA\Schema(
  *     description="Aliquotas model",
  *     title="Aliquotas model",
  *    required={},
  *     @OA\Xml(
  *         name="Aliquotas"
  *     )
  * )
  */
class Aliquotas extends Model
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

    protected $table = 'aliquotas';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['valor', 'referencia', 'emitente_id', 'company_id', 'uuid'];

    public function emitente(){
        return $this->belongsTo(Emitente::class, 'emitente_id', 'uuid');
    }
}
