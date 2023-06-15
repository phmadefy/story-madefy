<?php

namespace App\Http\Controllers;

use App\Repositories\CategoriasRepository;

/**
 * Class CategoriasController
 * @package App\Http\Controllers
 */
class CategoriasController extends Controller
{

    use ApiControllerTrait;


    /**
     * @OA\Post(
     *     path="/categorias",
     *     tags={"categorias"},
     *     operationId="addCategorias",
     *     summary="Add a new item",
     *       @OA\RequestBody(
     *            description="Object to add new item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/Categorias"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Categorias")
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
     *     path="/categorias/{uuid}",
     *     tags={"categorias"},
     *     operationId="getCategoriasById",
     *     summary="Get item by ID",
     *       @OA\Parameter(
     *            name="id",
     *            in="path",
     *           required=true,
     *        ),
     *       @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Categorias")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             ),
     *              @OA\Property(
     *              description="Retorno do tipo de categoria",
     *             title="tipo",
     *              property="tipo",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Get(
     *     path="/categorias",
     *     tags={"categorias"},
     *     operationId="getCategorias",
     *     summary="Get all items",
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Categorias")
     *              },
     *             @OA\Property(
     *              description="id",
     *             type="integer",
     *             title="id",
     *              property="id",
     *             ),
     *      @OA\Property(
     *              description="Retorno do tipo de categoria",
     *             title="tipo",
     *              property="tipo",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    /**
     * @OA\Put(
     *     path="/categorias/{uuid}",
     *     tags={"categorias"},
     *     operationId="updateCategorias",
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
     * 			@OA\JsonContent(ref="#/components/schemas/Categorias"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Categorias")
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
     *     path="/categorias/{uuid}",
     *     tags={"categorias"},
     *     operationId="deleteCategorias",
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
    protected $permission = 'categorias';

    /**
     * CategoriasController constructor.
     * @param CategoriasRepository $repository
     */
    public function __construct(CategoriasRepository $repository)
    {
        $this->repository = $repository;
    }
}
