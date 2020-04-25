<?php

namespace App\Http\Controllers\Api;

use App\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaidTransactionController
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'id' => [new Own('transactions')]
        ]);

        $transaction = Transaction::find($request->get('id'));

        $transaction->update([
            'paid' => true
        ]);

        return $transaction;
    }

    public function destroy(Transaction $paidTransaction)
    {
        $this->authorize('update', $paidTransaction);

        $paidTransaction->update([
            'paid' => false
        ]);

        return $paidTransaction;
    }
}
