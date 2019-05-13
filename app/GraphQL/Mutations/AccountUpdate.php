<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;
use App\Models\Account;

class AccountUpdate extends Resolver
{

    public function respond(Account $account, $input)
    {
        $account->update([
            'name' => $input['name'],
            'icon' => $input['icon'],
            'tracking' => $input['isTracking']
        ]);
        return $account;
    }
}
