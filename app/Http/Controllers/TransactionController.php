<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Rules\Own;
use App\Http\Resources\Transaction as TransactionResource;
use RRule\RRule;

class TransactionController extends Controller
{

    public function index(Account $account)
    {
        $this->authorize('view', $account);

        return TransactionResource::collection(
            $account->transactions()->with(['category', 'account'])->orderBy('date', 'desc')->paginate(25)
        );
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

        if (!empty(request('rrule'))) {
            $transaction->rrule = new RRule(request('rrule'));
        }

        $transaction->save();

        \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('balanceUpdated', $transaction->account);

        return new TransactionResource($transaction);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return new TransactionResource($transaction);
    }

    public function update(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if (!empty(request('rrule'))) {
            $transaction->rrule = new RRule(request('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $transaction->update(
            request()->validate([
                'payee' => 'required',
                'amount' => 'required|integer',
                'date' => 'required|date',
                'category_id' => [
                    'nullable',
                    new Own('categories')
                ]
            ])
        );

        \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('balanceUpdated', $transaction->account);

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();
    }

    public function clear(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->update([
            'cleared' => !$transaction->cleared
        ]);

        \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('balanceUpdated', $transaction->account);

        return new TransactionResource($transaction);
    }

}
