<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TransactionController extends Controller
{

    public function create(Request $request)
    {
        $this->authorize('create', Transaction::class);

        return Inertia::render('Transactions/Create', [
            'account' => $request->has('account')
                ? Account::find($request->get('account'))
                : null
        ]);
    }

    public function store()
    {
        $this->authorize('create', Transaction::class);

        $transaction = Transaction::make(
            request()->validate([
                'payee' => 'required',
                'account_id' => [
                    'required',
                    new Own('accounts')
                ],
                'category_id' => [
                    'nullable',
                    new Own('categories')
                ],
                'amount' => 'required|integer',
                'date' => 'required'
            ])
        );

        if (!empty(request('recurrence'))) {
            $transaction->recurrence = request('recurrence');
        }

        $transaction->save();

        return Redirect::route('accounts.show', [$transaction->account]);
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction
        ]);
    }

    public function update(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if (!empty(request('recurrence'))) {
            $transaction->recurrence = request('recurrence');
        } else {
            $transaction->recurrence = null;
        }

        $transaction->update(
            request()->validate([
                'payee' => 'required',
                'amount' => 'required|integer',
                'date' => 'required|date',
                'account_id' => [
                    'required',
                    new Own('accounts')
                ],
                'category_id' => [
                    'nullable',
                    new Own('categories')
                ]
            ])
        );

        return Redirect::route('accounts.show', [$transaction->account]);
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return Redirect::route('accounts.show', [$transaction->account]);
    }

    public function clear(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->update([
            'cleared' => !$transaction->cleared
        ]);

        return Redirect::back();
    }

}
