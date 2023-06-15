<?php

namespace App\Http\Controllers;

use App\Repositories\TiposCategoriaRepository;

/**
 * Class TiposCategoriaController
 * @package App\Http\Controllers
 */
class TiposCategoriaController extends Controller
{

    use ApiControllerTrait;


    /**
     * @OA\Post(
     *     path="/tipos-categoria",
     *     tags={"tipos-categoria"},
     *     operationId="addTiposCategoria",
     *     summary="Add a new item",
     *       @OA\RequestBody(
     *            description="Object to add new item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/TiposCategoria"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/TiposCategoria")
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
     *     path="/tipos-categoria/{id}",
     *     tags={"tipos-categoria"},
     *     operationId="getTiposCategoria_id",
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
     *                   @OA\Schema (ref="#/components/schemas/TiposCategoria")
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
     *     path="/tipos-categoria",
     *     tags={"tipos-categoria"},
     *     operationId="getTiposCategoria",
     *     summary="Get all items",
     *       @OA\Parameter(ref="#/components/parameters/fields"),
     *       @OA\Parameter(ref="#/components/parameters/where"),
     *       @OA\Parameter(ref="#/components/parameters/orderBy"),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/TiposCategoria")
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
     *     path="/tipos-categoria/{id}",
     *     tags={"tipos-categoria"},
     *     operationId="updateTiposCategoria",
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
     * 			@OA\JsonContent(ref="#/components/schemas/TiposCategoria"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/TiposCategoria")
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
     *     path="/tipos-categoria/{id}",
     *     tags={"tipos-categoria"},
     *     operationId="deleteTiposCategoria",
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
    protected $permission = 'tipos-categoria';

    /**
     * TiposCategoriaController constructor.
     * @param TiposCategoriaRepository $repository
     */
    public function __construct(TiposCategoriaRepository $repository)
    {
        $this->repository = $repository;
    }
}
