<?php

use App\Models\Account;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->creditCardType,
        'user_id' => factory(User::class)
    ];
});

$factory->state(Account::class, 'tracking', function (Faker $faker) {
    return [
        'tracking' => true,
    ];
});
