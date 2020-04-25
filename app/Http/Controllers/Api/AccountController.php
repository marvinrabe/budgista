<?php

namespace App\Http\Controllers\Api;

use App\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController
{
    use AuthorizesRequests;

    public function index()
    {
        return [
            'accounts' => Auth()->user()->accounts->each(fn ($account) => $account->append('balance'))
        ];
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        return [
            'account' => $account->append(['balance', 'cleared_balance', 'outstanding_balance']),
            'transactions' => $account
                ->transactions()
                ->current()
                ->with(['category', 'targetAccount'])
                ->orderBy('date', 'desc')
                ->paginate(25),
            'futureCount' => $account->transactions()->future()->count()
        ];
    }
}
