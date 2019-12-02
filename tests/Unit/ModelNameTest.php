<?php

namespace Pine\Policy\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Pine\Policy\Tests\Comment;
use Pine\Policy\Tests\TestCase;

class ModelNameTest extends TestCase
{
    use RefreshDatabase;

    protected $comment;

    public function setUp(): void
    {
        parent::setUp();

        $this->comment = factory(Comment::class)->create();
    }

    /** @test */
    public function a_model_can_use_model_name()
    {
        $this->assertEquals('comment', $this->comment->model_name);

        $this->assertEquals('model_name', array_search('comment', $this->comment->toArray()));
    }
}
