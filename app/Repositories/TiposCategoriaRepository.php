<?php

namespace App\Repositories;

use App\Repositories\Eloquent\Repository;

/**
 * Class TiposCategoriaRepository
 * @package App\Repositories
 */
class TiposCategoriaRepository extends Repository
{

    protected $relations = [];
    protected $deleteRelations = [];
    protected $hasCompany = false;
    protected $hasUuid = false;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Models\TiposCategoria';
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
        return 'App\Validators\TiposCategoriaValidator';
    }
}
