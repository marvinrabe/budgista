<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;
use App\GraphQL\Transformations\TransactionInputTransformer;
use App\Models\Transaction;

class TransactionUpdate extends Resolver
{

    public function respond(Transaction $transaction, $input)
    {
        $transaction->update(TransactionInputTransformer::transform($input)->toArray());

        return [
            $transaction->fresh()
        ];
    }

}
