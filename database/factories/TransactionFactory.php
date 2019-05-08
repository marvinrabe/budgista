<?php

use App\Models\Account;
use App\Models\Transaction;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'payee' => $faker->company,
        'amount' => $faker->randomNumber(),
        'date' => $faker->dateTimeThisMonth(),
        'account_id' => factory(Account::class),
        'category_id' => null
    ];
});
