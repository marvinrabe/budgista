<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClearedTransactionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'id' => [new Own('transactions')]
        ]);

        Transaction::find($request->get('id'))->update([
            'cleared' => true
        ]);

        return Redirect::back();
    }

    public function destroy(Transaction $clearedTransaction)
    {
        $this->authorize('update', $clearedTransaction);

        $clearedTransaction->update([
            'cleared' => false
        ]);

        return Redirect::back();
    }

}
