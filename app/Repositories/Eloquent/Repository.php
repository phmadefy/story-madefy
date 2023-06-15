<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use App\Services\ErrorService;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\LaravelValidator;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var
     */

    protected $validator;

    /**
     * @var App
     */
    protected $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $relation;

    protected $deleteRelations;

    protected $newModel;

    protected $newValidator;

    protected $user = null;

    protected $company = null;

    /**
     * @param App $app
     * @param Collection $collection
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function __construct()
    {
        $this->app = app();
        $this->makeModel();
        $this->setRelations();
        $this->makeValidator();

        if($this->user = Auth::user() && $this->hasCompany){
            $this->company = User::find($this->user)->company_id;
        }

    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();

    public abstract function relations();

    public abstract function validator();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {

        return $this->model
            ->where(function($q){
                if(!is_null($this->company)){
                    $q->where('company_id', '=', $this->company);
                }

            })
            ->get($columns);
    }

    public function setRelations()
    {
        return $this->relation = $this->relations();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {


            $order = $request->all()['order'] ?? null;

            $where = $request->all()['where'] ?? [];

            $whereNull = $request->all()['whereNull'] ?? [];

            $whereNotNull = $request->all()['whereNotNull'] ?? [];

            $whereDate = $request->all()['whereDate'] ?? [];

            $whereIn = $request->all()['whereIn'] ?? null;

            $whereHas = $request->all()['whereHas'] ?? null;

            $join = $request->all()['join'] ?? [];

            $limit = $request->all()['limit'] ?? null;
            $trash = $request->all()['trash'] ?? false;

            //   dd($trash);


            if ($where) {
                $where = explode(',', $where);
            }

            if ($whereDate) {
                $whereDate = explode(',', $whereDate);
            }


            $like = $request->all()['like'] ?? null;
            if ($like) {
                $like = explode(',', $like);
                $like[1] = '%' . $like[1] . '%';
            }

            try {
                $fieldsRaw = $request->all()['fields'];
            } catch (\Exception $e) {
                $fieldsRaw = null;
            }

            if (isset($fieldsRaw)) {
                $fields = '*';
                if (strpos($fieldsRaw, '.') === false) {
                    $fields = explode(',', $fieldsRaw);
                }
            } else {
                $fields = '*';
            }
            /**
             * @var $result \Illuminate\Database\Eloquent\Collection
             */
            $result = $this->model->select($fields)
                ->where(function($q){
                    if($this->hasCompany){
                        $q->where('company_id', '=', $this->company);
                    }
                })
                ->where(function ($query) use ($like) {
                    if ($like) {
                        return $query->where($like[0], 'like', $like[1]);
                    }
                    return $query;
                })
                ->where(function ($query) use ($where) {
                    if ($where) {
                        $j = 0;
                        while ($j < count($where)) {
                            if ($where[$j + 1] == 'NOT') {
                                $query = $query->whereNotNull($where[$j]);
                            } else if ($where[$j + 1] == 'IS') {
                                $query = $query->whereNull($where[$j]);
                            } else {
                                $query = $query->where($where[$j], $where[$j + 1], $where[$j + 2]);
                            }

                            $j = $j + 3;
                        }

                        return $query;
                    }
                    return $query;
                });

            if ($whereDate) {
                $j = 0;
                while ($j < count($whereDate)) {
                    $result = $result->whereDate($whereDate[$j], $whereDate[$j + 1], $whereDate[$j + 2]);
                    $j = $j + 3;
                }
            }

            $relations = $request->all()['relations'] ?? true;


            if ($join) {
                $join = explode(',', $join);
                $j = 0;
                while ($j < count($join)) {
                    $result = $result->join($join[$j], $join[$j + 1], $join[$j + 2], $join[$j + 3]);
                    $j = $j + 4;
                }
            }

            if ($relations !== 'false') {
                if ($relations == 'true') {
                    $result = $result->with($this->relations());
                } else {
                    $result = $result->with(explode(',', $relations));
                }
            }

            if ($order !== null) {
                $order = explode(',', $order);
                $o = 0;
                while ($o < count($order)) {
                    $result = $result->orderBy($order[$o], $order[$o + 1]);
                    $o = $o + 2;
                }
            }

            if ($limit !== null) {

                $result = $result->limit($limit);
            }

            if ($whereIn) {
                $whereIn = explode(',', $whereIn);
            }

            if ($whereIn !== null) {
                $campoWhereIn = array_shift($whereIn);
                $result = $result->whereIn($campoWhereIn, $whereIn);
            }

            if ($whereNull) {
                $whereNull = explode(',', $whereNull);
                foreach ($whereNull as $wn) {
                    $result = $result->whereNull($wn);
                }

            }

            if ($whereNotNull) {
                $whereNotNull = explode(',', $whereNotNull);
                foreach ($whereNotNull as $wnn) {
                    $result = $result->whereNotNull($wnn);
                }

            }

            if ($whereHas !== null) {
                $whereHas = explode(',', $whereHas);
                if (count($whereHas) == 1) {
                    $result = $result->whereHas($whereHas[0]);
                } else {
                    $result = $result->whereHas($whereHas[0], function ($h) use ($whereHas) {
                        $h->where($whereHas[1], $whereHas[2], $whereHas[3]);
                    });
                }

            }

            if ($trash) {
                $result = $result->withTrashed();
            }

            $return = $result->get()->toArray();

            if (strpos($fieldsRaw, '.') === false) {
                return $return;
            }
            foreach ($return as $key => $item) {
                $return[$key] = $this->returnFields($item, $fieldsRaw);
            }
            return response()->json($return);
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }
    }

    /**
     * @param string $value
     * @param string $key
     * @return array
     */
    public function lists($value, $key = null)
    {
        $lists = $this->model ->where(function($q){
            $q->where('company_id', '=', $this->company);
        })->lists($value, $key);
        if (is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 25, $columns = array('*'))
    {
        return $this->model ->where(function($q){
            $q->where('company_id', '=', $this->company);
        })->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            if(!is_null($this->company)){
                $data['company_id'] = $this->company;
            }

            $data['uuid'] = Str::uuid();

            return $this->model->create($data);
        } catch (ValidatorException $v) {
            return response()->json($v->getMessageBag(), 400);
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }
    }

    public function store(Request $request)
    {
        try {
            return $this->create($request->all());
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data)
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->where(function($q){
            $q->where('company_id', '=', $this->company);
        })->save();
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $record = $this->model->where('uuid', '=', $id)->first();

            if ($record) {
                return $record->update($data);
            }
            return response()->json(['error' => true, 'message' => ['Falha' => ['Registro removido previamente']]], 500);
        } catch (ValidatorException $e) {
            return response()->json($e->getMessageBag(), 400);
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }

    }

    /**
     * @param array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id)
    {
        if (!($model = $this->model->find($id))) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {

            if (!$this->canDelete($id)) {
                return response()->json('Registro sendo utilizado', 400);
            }
            return $this->model->where('uuid', '=', $id)->delete();
        } catch (ValidatorException $e) {
            return response()->json($e->getMessageBag(), 400);
        } catch (\Exception $e) {
            return ErrorService::sendError($e);
        }

    }

    public function canDelete($id)
    {
        if (isset($this->deleteRelations)) {
            $registro = $this->model->where('uuid', '=', $id)->first();
            foreach ($this->deleteRelations as $relation) {
                if (count($registro->$relation()->get()) > 0) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'), $request = null)
    {
        $relations = isset($request['relations']) ? explode(',', $request['relations']) : $this->relation;

        if($this->hasUuid === false){
            return $this->model->find($id);
        }

        return $this->model->where('uuid', '=', $id)->with($relations)->first();
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where(function($q){
            $q->where('company_id', '=', $this->company);
        })->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where('company_id', '=', $this->company)->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false)
    {
        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model->where(function($q){
            $q->where('company_id', '=', $this->company);
        })->get($columns);
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->setModel($this->model());
    }


    public function makeValidator()
    {
        return $this->setValidator($this->validator());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     * @return Model
     * @throws RepositoryException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if (!$this->newModel instanceof Model)
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $this->newModel;
    }

    public function setValidator($validator)
    {
        $this->newValidator = $this->app->make($validator);

        if (!$this->newValidator instanceof LaravelValidator)
            throw new Exception("Erro");

        return $this->validator = $this->newValidator;
    }

    public function getApp()
    {
        return $this->app;
    }


    public function getAudits(Request $request)
    {
        return $this->index($request)->audits;
    }

    public function returnFields($collection, $fieldsRaw, $lastCol = null)
    {
        $finalCol = [];
        if (!is_null($lastCol)) {
            $finalCol = $lastCol;
        }
        $fields = $fieldsRaw;
        if (!is_array($fieldsRaw)) {
            $fields = explode(',', $fieldsRaw);
        }
        foreach ($fields as $field) {
            $fieldsLevel = explode('.', $field);
            $firstField = array_shift($fieldsLevel);
            if (count($fieldsLevel) >= 1) {
                $finalCol[$firstField] = $this->returnFields($collection[$firstField], implode('.', $fieldsLevel), $finalCol[$firstField] ?? null);
            } else {
                $finalCol[$firstField] = $collection[$firstField];
            }
        }
        return $finalCol;
    }
}
