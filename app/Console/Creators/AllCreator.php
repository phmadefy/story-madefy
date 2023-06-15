<?php

/**
 * Created by PhpStorm.
 * User: georgeton
 * Date: 24/06/2017
 * Time: 14:49
 */

namespace App\Console\Creators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;


class AllCreator
{
    /**
     * @var Filesystem
     */
    protected $files;
    /**
     * @var
     */
    protected $name;
    /**
     * @var
     */
    protected $model;

    private $_default = '###insertNewRoute';

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->name;
    }

    /**
     * @param mixed $repository
     */
    public function setNome($name)
    {
        $this->name = $name;
    }


    /**
     * Create the repository.
     *
     * @param $repository
     * @param $model
     * @return int
     */
    public function create($name)
    {
        $name = ucfirst($name);
        $this->setNome($name);
        $this->createClass('model');
        $this->createClass('validator');
        $this->createClass('repository');
        $this->createClass('controller');

        Artisan::call("make:migration", ['name' => "create$name", '--create' => lcfirst($name)]);

        $this->updateRoute();
    }

    public function updateRoute()
    {
        $path = base_path('routes\api.php');
        $str = file_get_contents($path);

        $routeName = Str::kebab(lcfirst($this->getNome()));
        $controllerName = $this->getNome() . 'Controller';

        $newStr = "
    Route::resource('$routeName', '$controllerName');
$this->_default";

        $str = str_replace($this->_default, $newStr, $str);
        file_put_contents($path, $str);
    }

    /**
     * Get the path.
     *
     * @return string
     */
    protected function getPath($arq)
    {

        $path = '';
        $nome = '';

        switch ($arq) {
            case 'model':
                $path = '\App\Models';
                $nome = $this->getNome();
                break;
            case 'validator':
                $path = '\App\Validators';
                $nome = $this->getNome() . 'Validator';
                break;
            case 'repository':
                $path = '\App\Repositories';
                $nome = $this->getNome() . 'Repository';
                break;
            case 'controller':
                $path = '\App\Http\Controllers';
                $nome = $this->getNome() . 'Controller';
                break;
        }

        // Path.
        $path = base_path() . $path . DIRECTORY_SEPARATOR . $nome . '.php';
        // return path.
        return $path;
    }


    /**
     * Get the populate data.
     *
     * @return array
     */
    protected function getPopulateData($arq)
    {
        $populate_data = [];
        switch ($arq) {
            case 'model':
                $populate_data = [
                    'model_class' => $this->getNome(),
                    'model_namespace' => 'App\Models',
                    'model_table' => lcfirst($this->getNome())
                ];
                break;
            case 'validator':
                $populate_data = [
                    'validator_class' => $this->getNome() . 'Validator',
                    'validator_namespace' => 'App\Validators'

                ];
                break;
            case 'repository':
                $populate_data = [
                    'repository_class' => $this->getNome() . 'Repository',
                    'model_class' => $this->getNome(),
                    'validator_class' => $this->getNome() . 'Validator',
                    'repository_namespace' => 'App\Repositories'

                ];
                break;
            case 'controller':
                $populate_data = [
                    'repository_class' => $this->getNome() . 'Repository',
                    'controller_class' => $this->getNome() . 'Controller',
                    'permission_name' => Str::kebab($this->getNome()),
                    'controller_namespace' => 'App\Http\Controllers',
                    'lower_path_name' => Str::lower($this->getNome()),
                    'camel_path_name' => $this->getNome(),
                    'add_path_name' => "add" . $this->getNome(),
                    'get_path_name' => "get" . $this->getNome(),
                    'get_path_byid' => "get" . $this->getNome() . "ById",
                    'update_path_name' => "update" . $this->getNome(),
                    'delete_path_name' => "delete" . $this->getNome(),
                ];
                break;
        }


        // Return populate data.
        return $populate_data;
    }


    /**
     * Get the stub.
     *
     * @return string
     */
    protected function getStub($arq)
    {
        // Stub
        $stub = $this->files->get($this->getStubPath() . DIRECTORY_SEPARATOR . $arq . ".stub");
        // Return stub.
        return $stub;
    }

    /**
     * Get the stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        // Stub path.
        $stub_path = base_path() . '\App\Console\Stubs';
        // Return the stub path.
        return $stub_path;
    }

    /**
     * Populate the stub.
     *
     * @return mixed
     */
    protected function populateStub($arq)
    {
        // Populate data
        $populate_data = $this->getPopulateData($arq);
        // Stub
        $stub = $this->getStub($arq);
        // Loop through the populate data.
        foreach ($populate_data as $key => $value) {
            // Populate the stub.
            $stub = str_replace($key, $value, $stub);
        }
        // Return the stub.
        return $stub;
    }

    protected function createDirectory($arq)
    {
        $directory = '';
        switch ($arq) {
            case 'model':
                $directory = base_path() . '\App\Models';
                break;
            case 'validator':
                $directory = base_path() . '\App\Validators';
                break;
            case 'repository':
                $directory = base_path() . '\App\Repositories';
                break;
            case 'controller':
                $directory = base_path() . '\App\Http\Controllers';
                break;
        }


        // Check if the directory exists.
        if (!$this->files->isDirectory($directory)) {
            // Create the directory if not.
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    protected function createClass($arq)
    {
        $this->createDirectory($arq);

        // Result.
        $result = $this->files->put($this->getPath($arq), $this->populateStub($arq));
        // Return the result.
        return $result;
    }
}
