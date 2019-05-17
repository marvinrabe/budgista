<?php

use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'language' => 'de',
        'locale' => 'de',
        'currency' => 'EUR'
    ];
});

$factory->state(User::class, 'verified', [
    'email_verified_at' => \Carbon\Carbon::now(),
]);
