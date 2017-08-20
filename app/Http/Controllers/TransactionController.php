<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TransactionController extends Controller
{

    public function create(Budget $budget, Account $account)
    {
        return View::make('transactions.create')
            ->with('budget', $budget)
            ->with('categories', $this->getCategories($budget))
            ->with('account', $account);
    }

    public function store(Budget $budget, Account $account)
    {
        $rules = array(
            'payee' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('transactions.create', [$budget->id, $account->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }


        $category = Input::get('category_id');

        $transaction = new Transaction();
        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->category_id = empty($category)?null:$category;
        $transaction->budget_id = $budget->id;
        $transaction->account_id = $account->id;
        $transaction->save();

        Session::flash('message', 'Successfully created transaction!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function edit(Budget $budget, Account $account, Transaction $transaction)
    {
        return View::make('transactions.edit')
            ->with('transaction', $transaction)
            ->with('account', $account)
            ->with('categories', $this->getCategories($budget))
            ->with('budget', $budget);
    }

    public function update(Budget $budget, Account $account, Transaction $transaction)
    {
        $rules = array(
            'payee' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('transactions.edit', [$budget->id, $account->id, $transaction->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $category = Input::get('category_id');

        $transaction->date = Input::get('date');
        $transaction->payee = Input::get('payee');
        $transaction->memo = Input::get('memo');
        $transaction->amount = Input::get('amount');
        $transaction->category_id = empty($category)?null:$category;
        $transaction->save();

        Session::flash('message', 'Successfully updated transaction!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function destroy(Budget $budget, Account $account, Transaction $transaction)
    {
        $transaction->delete();

        Session::flash('message', 'Successfully deleted the transaction!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function clear(Budget $budget, Account $account, Transaction $transaction)
    {
        $transaction->cleared = !$transaction->cleared;
        $transaction->save();

        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    private function getCategories(Budget $budget)
    {
        $result = ['' => 'Income'];
        foreach ($budget->categories as $category) {
            $result[$category->id] = $category->name;
        }
        return $result;
    }
}
