<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RRule\RRule;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Transaction::class);
    }

    public function store(Budget $budget)
    {
        $rules = array(
            'payee' => 'required',
            'account_id' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('transactions.create', [$budget->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }


        $category = Input::get('category_id');

        $transaction = new Transaction();
        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->account_id = Input::get('account_id');
        $transaction->category_id = empty($category) ? null : $category;
        $transaction->budget_id = $budget->id;

        if (!empty(Input::get('rrule'))) {
            $transaction->rrule = new RRule(Input::get('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $transaction->save();

        Session::flash('message', 'Successfully created transaction!');
        return redirect()->route('accounts.show', [$budget->id, $transaction->account_id]);
    }

    public function update(Budget $budget, Transaction $transaction)
    {
        $rules = array(
            'payee' => 'required',
            'account_id' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('transactions.edit', [$budget->id, $transaction->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $category = Input::get('category_id');

        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->account_id = Input::get('account_id');
        $transaction->category_id = empty($category) ? null : $category;

        if (!empty(Input::get('rrule'))) {
            $transaction->rrule = new RRule(Input::get('rrule'));
        } else {
            $transaction->rrule = null;
        }

        $transaction->save();

        Session::flash('message', 'Successfully updated transaction!');
        return redirect()->route('accounts.show', [$budget->id, $transaction->account_id]);
    }

    public function destroy(Budget $budget, Transaction $transaction)
    {
        $transaction->delete();

        Session::flash('message', 'Successfully deleted the transaction!');
        return redirect()->route('accounts.show', [$budget->id, $transaction->account_id]);
    }

    public function clear(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->cleared = !$transaction->cleared;
        $transaction->save();

        return [
            'cleared' => $transaction->cleared
        ];
    }

}
