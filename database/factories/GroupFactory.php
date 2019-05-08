<?php

use App\Models\Group;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => factory(User::class)
    ];
});
