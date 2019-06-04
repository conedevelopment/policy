<?php

namespace Pine\Policy\Tests;

use Pine\Policy\PolicyServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [PolicyServiceProvider::class];
    }
}
