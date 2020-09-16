<?php

namespace Pine\Policy\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Pine\Policy\PolicyServiceProvider;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';


        $app->booting(function () use ($app) {
            $app->register(PolicyServiceProvider::class);
            $app->make('migrator')->path(__DIR__.'/migrations');
        });

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
