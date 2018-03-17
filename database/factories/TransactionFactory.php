<?php

use App\Models\Account;
use App\Models\Transaction;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'payee' => $faker->company,
        'amount' => $faker->randomFloat(2, -100, 100),
        'date' => $faker->dateTimeThisMonth(),
        'account_id' => function () {
            return factory(Account::class)->create()->id;
        },
        'category_id' => null
    ];
});
