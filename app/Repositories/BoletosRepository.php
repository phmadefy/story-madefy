<?php

namespace App\Repositories;

use App\Models\Boletos;
use App\Repositories\Eloquent\Repository;
use App\Services\BoletoBBService;

/**
 * Class BoletosRepository
 * @package App\Repositories
 */
class BoletosRepository extends Repository
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
        return 'App\Models\Boletos';
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
        return 'App\Validators\BoletosValidator';
    }

    public function create(array $data)
    {
        $boleto = parent::create($data);

        return (new BoletoBBService())->emitirBoleto($boleto->uuid);
    }

    public function print($uuid){
        $boleto = Boletos::where('uuid', '=', $uuid)->first() ?? null;

        if(is_null($boleto)){
            return response()->json(['message' => 'Boleto não encontrado'], 500);
        }

        switch ($boleto['banco_id']){
            case '1':
                return (new BoletoBBService())->printBoleto($boleto);
            default:
                return response()->json(['message' => 'Boleto não encontrado'], 500);
        }
    }
}
