<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;

class PaidTransactionController extends Controller
{
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
