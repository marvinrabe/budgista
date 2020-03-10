<?php

use App\Account;
use App\Transaction;
use App\User;
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

$factory->state(Transaction::class, 'transfer', function () {
    return [
        'payee' => trans('action.transfer'),
        'category_id' => null,
    ];
});

$factory->afterCreatingState(Transaction::class, 'transfer', function (Transaction $transaction) {
    $transaction->createRelated($transaction->account_id);
});
