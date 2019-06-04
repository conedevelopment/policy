<?php

namespace Pine\Policy\Tests\Unit;

use Pine\Policy\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelNameTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_model_can_use_model_name()
    {
        $this->assertTrue(true);
    }
}
