<?php

namespace App\Models;

use App\Models\Traits\HasObsDelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Categorias
 * @package App\Models
 */

 /**
  * @OA\Schema(
  *     description="Categorias model",
  *     title="Categorias model",
  *    required={},
  *     @OA\Xml(
  *         name="Categorias"
  *     )
  * )
  */
class Categorias extends Model
{

    /**
     * @OA\Property(
     *     description="Nome",
     *     title="nome",
     *      property="nome",
     * ),
     *
     * @OA\Property(
     *     description="Uuid",
     *     title="uuid",
     *      property="uuid",
     * ),
     *
     *  @OA\Property(
     *     description="Tipo de categoria (Ex: cat_clientes, cat_contas)",
     *     title="tipo",
     *      property="tipo",
     * ),
     *
     * @OA\Property(
     *     description="Status",
     *     title="status",
     *     type="boolean",
     *     default=false,
     *      property="status",
     * ),
     */

    use SoftDeletes, HasObsDelTrait;

    protected $table = 'categorias';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [];
}
