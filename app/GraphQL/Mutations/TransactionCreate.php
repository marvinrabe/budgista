<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;
use App\GraphQL\Transformations\TransactionInputTransformer;
use App\Models\Transaction;

class TransactionCreate extends Resolver
{

    public function respond($input)
    {
        return [
            Transaction::create(TransactionInputTransformer::transform($input)->toArray())->fresh()
        ];
    }

}
