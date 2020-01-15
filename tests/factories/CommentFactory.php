<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Pine\Policy\Tests\Models\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => mt_rand(1, 10),
        'body' => $faker->sentences(2, true),
    ];
});
