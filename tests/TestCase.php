<?php

namespace Pine\Policy\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Pine\Policy\PolicyServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__ . '/migrations'),
        ]);

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->withFactories(__DIR__ . '/factories');

        $this->artisan('migrate', ['--database' => 'testing']);

        $this->artisan('view:clear');

        View::addNamespace('policy', __DIR__ . '/views');

        Route::get('/policy/{view}', function ($view) {
            return view("policy::{$view}");
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:tjr4OdXhohUfIUhfVeZcmg+psaPkfTaKgl9GuW1FjY8=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            PolicyServiceProvider::class,
            ConsoleServiceProvider::class,
        ];
    }
}
