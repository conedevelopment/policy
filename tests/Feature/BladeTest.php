<?php

namespace Pine\Policy\Tests\Feature;

use Pine\Policy\Tests\TestCase;

class BladeTest extends TestCase
{
    /** @test */
    public function current_user_can_be_printed_via_blade_directive()
    {
        $this->actingAs($this->user)
            ->get('/policy/current-user')
            ->assertSee("window['user'] = ".$this->user->toJson(), false);
    }
    /** @test */
    public function current_user_can_have_custom_key()
    {
        $this->actingAs($this->user)
            ->get('/policy/custom-key')
            ->assertSee("window['admin'] = ".$this->user->toJson(), false);
    }
}
