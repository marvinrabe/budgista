<?php

use App\Models\Category;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => factory(User::class)
    ];
});
