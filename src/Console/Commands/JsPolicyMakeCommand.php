<?php

namespace Pine\Policy\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class JsPolicyMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:js-policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new JavaScript policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'JavaScript Policy';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/Policy.stub';
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        $name = class_basename(str_replace('\\', '/', $rawName));

        $path = "{$this->laravel['path']}/../resources/js/policies/{$name}Policy.js";

        return file_exists($path);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $name = class_basename(str_replace('\\', '/', $name));

        $model = Str::lower($name);

        $stub = str_replace(
            ['{Class}', '{model}'],
            [$name, $model === 'user' ? 'model' : $model],
            $stub
        );

        return $this;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = class_basename(str_replace('\\', '/', $name));

        return "{$this->laravel['path']}/../resources/js/policies/{$name}Policy.js";
    }
}
