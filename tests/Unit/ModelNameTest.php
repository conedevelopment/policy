<?php

namespace Pine\Policy\Tests\Unit;

use Pine\Policy\Tests\Factories\CommentFactory;
use Pine\Policy\Tests\TestCase;

class ModelNameTest extends TestCase
{
    protected $comment;

    public function setUp(): void
    {
        parent::setUp();

        $this->comment = CommentFactory::new()->create();
    }

    /** @test */
    public function a_model_can_use_model_name()
    {
        $this->assertEquals('comment', $this->comment->model_name);

        $this->assertEquals('model_name', array_search('comment', $this->comment->toArray()));
    }
}
