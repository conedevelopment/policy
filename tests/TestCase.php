<?php

namespace Pine\Policy\Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pine\Policy\PolicyServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(['--path' => realpath(__DIR__.'/migrations')]);
        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->withFactories(__DIR__.'/factories');
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->artisan('view:clear');

        View::addNamespace('policy', __DIR__.'/views');

        Route::get('/policy/{view}', function ($view) {
            return view("policy::{$view}");
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:tjr4OdXhohUfIUhfVeZcmg+psaPkfTaKgl9GuW1FjY8=');
        $app['config']->set('database.default', 'testing');
    }

    protected function getPackageProviders($app)
    {
        return [
            PolicyServiceProvider::class,
            ConsoleServiceProvider::class,
        ];
    }
}
