<?php

namespace App\Http\Controllers;

use App\Repositories\AliquotasRepository;
use Illuminate\Http\Request;

/**
 * Class AliquotasController
 * @package App\Http\Controllers
 */
class AliquotasController extends Controller
{

    use ApiControllerTrait;


    /**
     * @OA\Post(
     *     path="/aliquotas",
     *     tags={"aliquotas"},
     *     operationId="addAliquotas",
     *     summary="Add a new item",
     *       @OA\RequestBody(
     *            description="Object to add new item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/Aliquotas"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Aliquotas")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             )
     *          ),
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", ref="#/components/schemas/validate_message"),
     *         )
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Get(
     *     path="/aliquotas/{uuid}",
     *     tags={"aliquotas"},
     *     operationId="getAliquotasById",
     *     summary="Get item by ID",
     *       @OA\Parameter(
     *            name="id",
     *            in="path",
     *           required=true,
     *        ),
     *       @OA\Parameter(ref="#/components/parameters/fields"),
     *       @OA\Parameter(ref="#/components/parameters/where"),
     *       @OA\Parameter(ref="#/components/parameters/orderBy"),
     *       @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Aliquotas")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Get(
     *     path="/aliquotas",
     *     tags={"aliquotas"},
     *     operationId="getAliquotas",
     *     summary="Get all items",
     *       @OA\Parameter(ref="#/components/parameters/fields"),
     *       @OA\Parameter(ref="#/components/parameters/where"),
     *       @OA\Parameter(ref="#/components/parameters/orderBy"),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Aliquotas")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Put(
     *     path="/aliquotas/{uuid}",
     *     tags={"aliquotas"},
     *     operationId="updateAliquotas",
     *     summary="Update item",
     *       @OA\Parameter(
     *            name="id",
     *            description="",
     *            in="path",
     *            required=true,
     *        ),
     *       @OA\RequestBody(
     *            description="Object to update item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/Aliquotas"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Aliquotas")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Delete (
     *     path="/aliquotas/{uuid}",
     *     tags={"aliquotas"},
     *     operationId="deleteAliquotas",
     *     summary="Delete item",
     *       @OA\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Item not found",
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    protected $repository;
    protected $permission = 'aliquotas';

    /**
     * AliquotasController constructor.
     * @param AliquotasRepository $repository
     */
    public function __construct(AliquotasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByEmitente($id)
    {
        return $this->repository->getByEmitente($id);
    }
}
