<?php

namespace App\Repositories;

use App\Repositories\Eloquent\Repository;

/**
 * Class BancosRepository
 * @package App\Repositories
 */
class BancosRepository extends Repository
{

    protected $relations = [];
    protected $deleteRelations = [];
    protected $hasCompany = true;
    protected $hasUuid = true;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Models\Bancos';
    }

    /**
     * @return mixed
     */
    public function relations()
    {
        return $this->relations;
    }

    /**
     * @return string
     */
    public function validator()
    {
        return 'App\Validators\BancosValidator';
    }
}
