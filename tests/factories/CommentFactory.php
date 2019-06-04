<?php

use Faker\Generator as Faker;

$factory->define(Pine\Policy\Tests\Comment::class, function (Faker $faker) {
    return [
        'user_id' => mt_rand(1, 10),
        'body' => $faker->sentences(2, true),
    ];
});
