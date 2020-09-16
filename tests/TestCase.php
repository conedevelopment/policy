<?php

namespace Pine\Policy\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Pine\Policy\Tests\Factories\UserFactory;

class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();

        // $this->app->afterResolving('migrator', function ($migrator) {
        //     $migrator->path(__DIR__.'/migrations');
        // });

        View::addNamespace('policy', __DIR__.'/views');

        Route::get('/policy/{view}', function ($view) {
            return view("policy::{$view}");
        });
    }
}
