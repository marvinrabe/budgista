<?php

use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
