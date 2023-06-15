<?php

namespace App\Http\Controllers;

use App\Repositories\CfgBoletosRepository;

/**
 * Class CfgBoletosController
 * @package App\Http\Controllers
 */
class CfgBoletosController extends Controller
{

    use ApiControllerTrait;


    /**
     * @OA\Post(
     *     path="/cfg-boletos",
     *     tags={"cfg-boletos"},
     *     operationId="addCfgBoletos",
     *     summary="Add a new item",
     *       @OA\RequestBody(
     *            description="Object to add new item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/CfgBoletos"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/CfgBoletos")
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
     *     path="/cfg-boletos/{uuid}",
     *     tags={"cfg-boletos"},
     *     operationId="getCfgBoletosById",
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
     *                   @OA\Schema (ref="#/components/schemas/CfgBoletos")
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
     *     path="/cfg-boletos",
     *     tags={"cfg-boletos"},
     *     operationId="getCfgBoletos",
     *     summary="Get all items",
     *       @OA\Parameter(ref="#/components/parameters/fields"),
     *       @OA\Parameter(ref="#/components/parameters/where"),
     *       @OA\Parameter(ref="#/components/parameters/orderBy"),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/CfgBoletos")
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
     *     path="/cfg-boletos/{uuid}",
     *     tags={"cfg-boletos"},
     *     operationId="updateCfgBoletos",
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
     * 			@OA\JsonContent(ref="#/components/schemas/CfgBoletos"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/CfgBoletos")
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
     *     path="/cfg-boletos/{uuid}",
     *     tags={"cfg-boletos"},
     *     operationId="deleteCfgBoletos",
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
    protected $permission = 'cfg-boletos';

    /**
     * CfgBoletosController constructor.
     * @param CfgBoletosRepository $repository
     */
    public function __construct(CfgBoletosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByEmitente($id){
        return $this->repository->getByEmitente($id);
    }
}
