<?php

namespace App\Http\Controllers;

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

    public function create(Budget $budget)
    {
        return View::make('transactions.create')
            ->with('budget', $budget)
            ->with('categories', $this->getCategories($budget))
            ->with('accounts', $this->getAccounts($budget));
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

    public function edit(Budget $budget, Transaction $transaction)
    {
        return View::make('transactions.edit')
            ->with('transaction', $transaction)
            ->with('categories', $this->getCategories($budget))
            ->with('budget', $budget)
            ->with('accounts', $this->getAccounts($budget));
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

    public function clear(Budget $budget, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->cleared = !$transaction->cleared;
        $transaction->save();

        return redirect()->route('accounts.show', [$budget->id, $transaction->account_id]);
    }

    private function getCategories(Budget $budget)
    {
        $result = ['' => 'Income'];
        foreach ($budget->categories as $category) {
            $result[$category->id] = $category->name;
        }
        return $result;
    }

    private function getAccounts(Budget $budget)
    {
        $result = [];
        foreach ($budget->accounts as $account) {
            $result[$account->id] = $account->name;
        }
        return $result;
    }
}
