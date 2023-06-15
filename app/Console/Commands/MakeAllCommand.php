<?php

namespace App\Console\Commands;

use App\Console\Creators\AllCreator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:all';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria todos as classes necessarias';
    /**
     * @var AllCreator
     */
    protected $creator;
    /**
     * @var
     */
    protected $composer;
    /**
     * @param AllCreator $creator
     */
    public function __construct(AllCreator $creator)
    {
        parent::__construct();
        // Set the creator.
        $this->creator  = $creator;
        // Set composer.
        $this->composer = app()['composer'];
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the arguments.
        $arguments = $this->argument();
        // Get the options.
        $options   = $this->option();
        // Write repository.
        $this->writeRepository($arguments, $options);
        // Dump autoload.
        $this->composer->dumpAutoloads();
    }
    /**
     * @param $arguments
     * @param $options
     */
    protected function writeRepository($arguments, $options)
    {
        // Set repository.
        $repository = $arguments['repository'];

        // Create the repository.
        if($this->creator->create($repository))
        {
            // Information message.
            $this->info("Successfully created the repository class");
        }
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['repository', InputArgument::REQUIRED, 'The repository name.']
        ];
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model name.', null],
        ];
    }
}
