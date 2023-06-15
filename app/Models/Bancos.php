<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Bancos
 * @package App\Models
 */

 /**
  * @OA\Schema(
  *     description="Bancos model",
  *     title="Bancos model",
  *    required={},
  *     @OA\Xml(
  *         name="Bancos"
  *     )
  * )
  */
class Bancos extends Model
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

    protected $table = 'bancos';
    protected $primaryKey = 'codigo';
    protected $guarded = ['deleted_at'];
    protected $fillable = ['descricao'];
    public $timestamps = false;
}
