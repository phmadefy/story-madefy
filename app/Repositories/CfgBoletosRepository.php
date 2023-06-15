<?php

namespace App\Repositories;

use App\Models\Aliquotas;
use App\Models\CfgBoletos;
use App\Repositories\Eloquent\Repository;
use Illuminate\Http\Request;

/**
 * Class CfgBoletosRepository
 * @package App\Repositories
 */
class CfgBoletosRepository extends Repository
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
        return 'App\Models\CfgBoletos';
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
        return 'App\Validators\CfgBoletosValidator';
    }

    public function getByEmitente($id){
        return CfgBoletos::where('emitente_id', '=', $id)
            ->where('company_id', '=', $this->company)
            ->first();

    }
}
