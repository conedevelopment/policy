<?php

namespace Pine\Policy\Tests\Feature;

use Pine\Policy\Tests\TestCase;

class BladeTest extends TestCase
{
    /** @test */
    public function current_user_can_be_printed_via_blade_directive()
    {
        $this->get('/policy/current-user')->assertSee('window.user = ');
    }
    /** @test */
    public function current_user_can_have_custom_key()
    {
        $this->get('/policy/custom-key')->assertSee('window.admin = ');
    }
}
