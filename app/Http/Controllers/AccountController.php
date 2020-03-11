<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        return Inertia::render('Accounts/Index');
    }

    public function create()
    {
        return Inertia::render('Accounts/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'initial_balance' => ['nullable', 'integer'],
            'tracking' => ['nullable', 'boolean'],
            'icon' => [
                'nullable',
                'string',
                Rule::in(config('icons.account')),
            ]
        ]);

        $account = Auth::user()->accounts()->create(
            $request->only(['name', 'tracking', 'icon'])
        );

        if ($initialBalance = $request->input('initial_balance')) {
            $account->reconcile($initialBalance);
        }

        return Redirect::route('accounts.show', [$account]);
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        return Inertia::render('Accounts/Show', [
            'account' => $account
                ->append('balance_cleared'),
            'transactions' => $account
                ->transactions()
                ->current()
                ->with('category')
                ->orderBy('date', 'desc')
                ->paginate(25),
            'futureCount' => $account->transactions()->future()->count()
        ]);
    }

    public function future(Account $account)
    {
        $this->authorize('view', $account);

        return Inertia::render('Accounts/Show', [
            'account' => $account,
            'transactions' => $account
                ->transactions()
                ->future()
                ->with('category')
                ->orderBy('date', 'asc')
                ->paginate(25),
            'futureCount' => $account->transactions()->future()->count()
        ]);
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);

        return Inertia::render('Accounts/Edit', [
            'account' => $account
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $account->update(
            $request->validate([
                'name' => 'required',
                'tracking' => ['nullable', 'boolean'],
                'icon' => [
                    'nullable',
                    'string',
                    Rule::in(config('icons.account')),
                ]
            ])
        );

        return Redirect::route('accounts.show', [$account]);
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();

        return Redirect::route('budget');
    }

    public function reconcile(Account $account)
    {
        $this->authorize('update', $account);

        request()->validate([
            'amount' => 'required|integer'
        ]);

        $account->reconcile(request('amount'));

        return Redirect::back();
    }

}
