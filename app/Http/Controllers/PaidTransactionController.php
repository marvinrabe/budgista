<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaidTransactionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'id' => [new Own('transactions')]
        ]);

        Transaction::find($request->get('id'))->update([
            'paid' => true
        ]);

        return Redirect::back();
    }

    public function destroy(Transaction $paidTransaction)
    {
        $this->authorize('update', $paidTransaction);

        $paidTransaction->update([
            'paid' => false
        ]);

        return Redirect::back();
    }

}
