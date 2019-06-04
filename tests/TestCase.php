<?php

namespace Pine\Policy\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Pine\Policy\PolicyServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        View::addNamespace('policy', __DIR__ . '/views');

        Route::get('/policy/{view}', function ($view) {
            return view("policy::{$view}");
        });
    }

    protected function getPackageProviders($app)
    {
        return [PolicyServiceProvider::class];
    }
}
