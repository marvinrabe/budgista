<?php

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'payee' => $faker->company,
        'amount' => $faker->numberBetween(-999999, 999999),
        'date' => $faker->dateTimeThisMonth(),
        'account_id' => function ($data) {
            return factory(Account::class)->create([
                'user_id' => $data['user_id']
            ]);
        },
        'category_id' => null
    ];
});

$factory->state(Transaction::class, 'cleared', function () {
    return [
        'cleared' => true,
    ];
});

$factory->state(Transaction::class, 'uncleared', function () {
    return [
        'cleared' => false,
    ];
});
