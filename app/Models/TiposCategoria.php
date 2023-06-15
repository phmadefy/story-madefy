<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class TiposCategoria
 * @package App\Models
 */

 /**
  * @OA\Schema(
  *     description="TiposCategoria model",
  *     title="TiposCategoria model",
  *    required={},
  *     @OA\Xml(
  *         name="TiposCategoria"
  *     )
  * )
  */
class TiposCategoria extends Model
{

    /**
     * @OA\Property(
     *     description="Descrição",
     *     title="descricao",
     *      property="descricao",
     * ),
     *
     * @OA\Property(
     *     description="Codigo",
     *     title="codigo",
     *      property="codigo",
     * ),
     *
     * @OA\Property(
     *     description="Endpoint",
     *     title="endPoint",
     *      property="endPoint",
     * ),
     */


    use HasObsDelTrait;

    protected $table = 'tiposCategoria';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['descricao', 'codigo', 'endPoint'];
}
