<?php

namespace App\Http\Controllers\Api;

class AccountController
{
    public function index()
    {
        return [
            'accounts' => Auth()->user()->accounts->each(fn ($account) => $account->append('balance'))
        ];
    }
}
