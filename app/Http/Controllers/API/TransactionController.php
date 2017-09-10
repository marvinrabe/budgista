<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Budget;
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

    public function store(Request $request, Budget $budget)
    {
        $this->validate($request, [
            'payee' => 'required',
            'account_id' => 'required'
        ]);

        $account = Account::find(Input::get('account_id'));
        $this->authorize('update', $account);

        $category = Category::find(Input::get('category_id'));
        $this->authorize('update', $category);

        $transaction = new Transaction();
        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->account_id = $account->id;
        $transaction->category_id = empty($category->id) ? null : $category->id;
        $transaction->budget_id = $budget->id;

        if (!empty(Input::get('rrule'))) {
            $transaction->rrule = new RRule(Input::get('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $transaction->save();

        return new TransactionResource($transaction);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'payee' => 'required',
            'account_id' => 'required'
        ]);

        $account = Account::find(Input::get('account_id'));
        $this->authorize('update', $account);

        $category = Category::find(Input::get('category_id'));
        $this->authorize('update', $category);

        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->account_id = $account->id;
        $transaction->category_id = empty($category->id) ? null : $category->id;

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
