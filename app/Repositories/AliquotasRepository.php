<?php

namespace App\Repositories;

use App\Models\Aliquotas;
use App\Repositories\Eloquent\Repository;
use App\Services\ErrorService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class AliquotasRepository
 * @package App\Repositories
 */
class AliquotasRepository extends Repository
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
        return 'App\Models\Aliquotas';
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
        return 'App\Validators\AliquotasValidator';
    }

    public function create(array $data)
    {

        try {

            $ret = [];
            foreach ($data as $d) {
                $d['referencia'] = Carbon::createFromFormat('Y-m', $d['referencia'])->startOfMonth()->toDateString();
                if(Aliquotas::where('emitente_id', '=', $d['emitente_id'])->where('referencia', '=', $d['referencia'])->exists()){
                    $ret[] = 'Referência já existente';
                }else{
                    $ret[] = parent::create($d);
                }

            }

            return $ret;
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }
    }

    public function getByEmitente($id){

        $resp = Aliquotas::where('emitente_id', '=', $id)->orderBy('referencia', 'desc');

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return $resp;
    }
}
