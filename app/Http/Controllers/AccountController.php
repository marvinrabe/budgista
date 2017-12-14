<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function index()
    {
        return AccountResource::collection(Auth::user()->accounts()->get());
    }

    public function store()
    {
        $this->authorize('create', Account::class);

        $account = new Account(
            request()->validate([
                'name' => 'required'
            ])
        );

        Auth::user()->accounts()->save($account);

        return new AccountResource($account);
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        return new AccountResource($account);
    }

    public function update(Account $account)
    {
        $this->authorize('update', $account);

        $account->update(
            request()->validate([
                'name' => 'required'
            ])
        );

        return new AccountResource($account);
    }

    public function reconcile(Account $account)
    {
        $this->authorize('update', $account);

        request()->validate([
            'amount' => 'required|integer'
        ]);

        $currentBalance = $account->workingBalance();
        $newBalance = request('amount');
        $difference = $newBalance - $currentBalance;

        $account->transactions()->create([
            'date' => Carbon::now(),
            'payee' => trans('action.reconciliation'),
            'amount' => $difference
        ]);

        $account->transactions()->update(['cleared' => true]);

        return new AccountResource($account);
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();

        return [];
    }

}
