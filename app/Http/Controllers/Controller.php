<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="StoreFy API",
     *      description="StoreFY Swagger OpenApi description",
     *      @OA\Contact(
     *          email="georgeton.ufg@gmail.com"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */


    /**
     * @OA\Server(
     *      url="http://localhost:8000/api",
     *      description="Api local server"
     *  )
     *
     */

    /**
     * @OA\Server(
     *      url="http://storefy.workingtech.com.br:31080/api",
     *      description="Api dev server"
     *  )
     *
     */

    /**
     * @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *       type="http",
     *       scheme="bearer",
     *       bearerFormat="JWT"
     *       )
     */


    /**
     * @OA\Schema(
     *
     *     schema="validate_message",
     *     required={"code", "message"},
     *     title="Error message",
     *     description="Error jso1n",
     *     type="object",
     *     @OA\Xml(name="ErrorMessage"),
     *     @OA\Property(property="code", type="string", readOnly=true),
     *     @OA\Property(property="message", type="string", readOnly=true, minLength=8)
     * )
     */


    /**
     * @OA\Parameter(
     *            name="fields",
     *            description="Fields to return",
     *            in="query",
     *   ),
     *
     *  @OA\Parameter(
     *            name="where",
     *            description="filter of any database fields (always send ternaries: 'field,operator,value')'",
     *            in="query",
     *   )
     *
     *   *  @OA\Parameter(
     *            name="orderBy",
     *            description="Order ny database fields (always send: 'field,order')'",
     *            in="query",
     *   )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
