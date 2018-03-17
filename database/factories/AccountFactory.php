<?php

use App\Models\Account;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->creditCardType,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
