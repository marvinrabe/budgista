<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\Transaction as TransactionResource;
use RRule\RRule;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Transaction::class);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payee' => 'required',
            'account_id' => 'required',
            'amount' => 'required'
        ]);

        $account = Account::find(request('account_id'));
        $this->authorize('update', $account);

        $transaction = new Transaction();

        $transaction->category_id = null;
        $category_id = request('category_id');
        if(!empty($category_id)) {
            $category = Category::find($category_id);
            $this->authorize('update', $category);
            $transaction->category_id = $category->id;
        }

        $transaction->date = request('date');
        $transaction->payee = request('payee');
        $transaction->amount = request('amount');

        if (!empty(request('rrule'))) {
            $transaction->rrule = new RRule(request('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $account->transactions()->save($transaction);

        return new TransactionResource($transaction);
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payee' => 'required',
            'amount' => 'required'
        ]);

        $transaction->category_id = null;
        $category_id = request('category_id');
        if(!empty($category_id)) {
            $category = Category::find($category_id);
            $this->authorize('update', $category);
            $transaction->category_id = $category->id;
        }

        $transaction->date = request('date');
        $transaction->payee = request('payee');
        $transaction->amount = request('amount');

        if (!empty(request('rrule'))) {
            $transaction->rrule = new RRule(request('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $transaction->save();

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return [];
    }

    public function clear(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->cleared = !$transaction->cleared;
        $transaction->save();

        return new TransactionResource($transaction);
    }

}
