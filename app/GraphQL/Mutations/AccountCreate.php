<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;

class AccountCreate extends Resolver
{

    public function respond($input, $initialBalance = 0)
    {
        $account = Auth()->user()->accounts()->create([
            'name' => $input['name'],
            'icon' => $input['icon'],
            'tracking' => $input['isTracking']
        ]);

        if ($initialBalance) {
            $account->reconcile($initialBalance);
        }

        return $account;
    }
}
