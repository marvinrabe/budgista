<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $this->validate($request, [
            'payee' => 'required',
            'account_id' => 'required',
            'amount' => 'required'
        ]);

        $account = Account::find(Input::get('account_id'));
        $this->authorize('update', $account);

        $transaction = new Transaction();

        $transaction->category_id = null;
        $category_id = request('category_id');
        if(!empty($category_id)) {
            $category = Category::find($category_id);
            $this->authorize('update', $category);
            $transaction->category_id = $category->id;
        }

        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->amount = Input::get('amount');

        if (!empty(Input::get('rrule'))) {
            $transaction->rrule = new RRule(Input::get('rrule'));
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
        $this->validate($request, [
            'payee' => 'required',
            'amount' => 'required'
        ]);

        $transaction->category_id = null;
        $category_id = Input::get('category_id');
        if(!empty($category_id)) {
            $category = Category::find($category_id);
            $this->authorize('update', $category);
            $transaction->category_id = $category->id;
        }

        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->amount = Input::get('amount');

        if (!empty(Input::get('rrule'))) {
            $transaction->rrule = new RRule(Input::get('rrule'));
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
