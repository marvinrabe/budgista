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
        // validate
        // read more on validation at http://laravel.com/docs/validation
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
        $transaction->budget_id = $budget->id;
        $transaction->category_id = empty($category)?null:$category;
        $transaction->account_id = $account->id;
        $transaction->save();

        // redirect
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
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('transactions.edit', [$budget->id, $account->id, $transaction->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $transaction->name = Input::get('name');
        $transaction->save();

        // redirect
        Session::flash('message', 'Successfully updated transaction!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function destroy(Budget $budget, Account $account, Transaction $transaction)
    {
        $transaction->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the transaction!');
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
