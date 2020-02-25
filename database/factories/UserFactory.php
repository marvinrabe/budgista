<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'language' => 'de',
        'locale' => 'de',
        'currency' => 'EUR'
    ];
});

$factory->state(User::class, 'verified', [
    'email_verified_at' => \Carbon\Carbon::now(),
]);
