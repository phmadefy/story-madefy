<?php
/**
 * Created by PhpStorm.
 * User: georgeton
 * Date: 29/05/2017
 * Time: 14:35
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait ApiControllerTrait
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
      public function store(Request $request)
      {
          return $this->repository->store($request);
      }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
       return $this->repository->find($id, array('*'), $request->all() ?? null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->repository->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
       return $this->repository->delete($id);
    }

    public function get(Request $request)
    {
        return $this->repository->index($request);
    }

    public function getAudits(Request $request){
        return $this->repository->index($request)->audits;
    }

}
