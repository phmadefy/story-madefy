<?php

namespace App\Http\Controllers;

use App\Repositories\BoletosRepository;

/**
 * Class BoletosController
 * @package App\Http\Controllers
 */
class BoletosController extends Controller
{

    use ApiControllerTrait;


    /**
     * @OA\Post(
     *     path="/boletos",
     *     tags={"boletos"},
     *     operationId="addBoletos",
     *     summary="Add a new item",
     *       @OA\RequestBody(
     *            description="Object to add new item",
     *            required=true,
     * 			@OA\JsonContent(ref="#/components/schemas/Boletos"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Boletos")
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
     *     path="/boletos/{uuid}",
     *     tags={"boletos"},
     *     operationId="getBoletosById",
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
     *                   @OA\Schema (ref="#/components/schemas/Boletos")
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
     *     path="/boletos",
     *     tags={"boletos"},
     *     operationId="getBoletos",
     *     summary="Get all items",
     *       @OA\Parameter(ref="#/components/parameters/fields"),
     *       @OA\Parameter(ref="#/components/parameters/where"),
     *       @OA\Parameter(ref="#/components/parameters/orderBy"),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Boletos")
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
     *     path="/boletos/{uuid}",
     *     tags={"boletos"},
     *     operationId="updateBoletos",
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
     * 			@OA\JsonContent(ref="#/components/schemas/Boletos"),
     *        ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             allOf={
     *                   @OA\Schema (ref="#/components/schemas/Boletos")
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
     *     path="/boletos/{uuid}",
     *     tags={"boletos"},
     *     operationId="deleteBoletos",
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

    /**
     * @OA\Get(
     *     path="/boletos/print/{uuid}",
     *     tags={"boletos"},
     *     operationId="printBoletosById",
     *     summary="Get item by ID",
     *       @OA\Parameter(
     *            name="uuid",
     *            in="path",
     *           required=true,
     *        ),
     *       @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *              description="html to print (do not use in swagger)",
     *             title="html",
     *              property="id",
     *             )
     *          ),
     *      ),
     *        security={{"bearerAuth":{}}}
     * )
     */

    protected $repository;
    protected $permission = 'boletos';

    /**
     * BoletosController constructor.
     * @param BoletosRepository $repository
     */
    public function __construct(BoletosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function print($uuid){
        return $this->repository->print($uuid);
    }
}
