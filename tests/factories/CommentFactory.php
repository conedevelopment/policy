<?php

namespace Pine\Policy\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pine\Policy\Tests\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(1, 10),
            'body' => $this->faker->sentences(2, true),
        ];
    }
}
