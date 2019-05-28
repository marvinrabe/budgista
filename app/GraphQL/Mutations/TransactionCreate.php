<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;
use App\GraphQL\Transformations\TransactionInputTransformer;
use App\Models\Transaction;

class TransactionCreate extends Resolver
{

    public function respond($input)
    {
        $transaction = Transaction::make(TransactionInputTransformer::transform($input)->toArray());

        $transactions = Transaction::processRecurring($transaction);

        $result = [];
        foreach ($transactions as $transaction) {
            $result[] = $transaction->fresh();
        }
        return $result;
    }

}
