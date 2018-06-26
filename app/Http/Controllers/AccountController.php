<?php

namespace App\Http\Controllers;

use App\Http\Resources\Account as AccountResource;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function index()
    {
        return AccountResource::collection(Auth::user()->accounts);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Account::class);

        $request->validate([
            'name' => 'required',
            'initial_balance' => 'nullable|integer',
            'tracking' => 'nullable|boolean',
            'icon' => [
                'nullable',
                'string',
                Rule::in(config('icons.account')),
            ]
        ]);

        $account = Auth::user()->accounts()->create(
            $request->only(['name', 'tracking', 'icon'])
        );

        $initialBalance = $request->input('initial_balance');
        if($initialBalance) {
            $account->reconcile($initialBalance);
        }

        return new AccountResource($account->refresh());
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
                'name' => 'required',
                'tracking' => 'nullable|boolean',
                'icon' => [
                    'nullable',
                    'string',
                    Rule::in(config('icons.account')),
                ]
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

        $account->reconcile(request('amount'));

        return new AccountResource($account);
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();
    }

}
