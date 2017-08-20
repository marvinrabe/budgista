<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AccountController extends Controller
{

    public function create(Budget $budget)
    {
        return View::make('accounts.create')
            ->with('budget', $budget);
    }

    public function store(Budget $budget)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('accounts.create', [$budget->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $account = new Account();
        $account->name = Input::get('name');
        $account->budget_id = $budget->id;
        $account->save();

        // redirect
        Session::flash('message', 'Successfully created account!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function show(Budget $budget, Account $account)
    {
        return View::make('accounts.show')
            ->with('account', $account)
            ->with('budget', $budget);
    }


    public function edit(Budget $budget, Account $account)
    {
        return View::make('accounts.edit')
            ->with('account', $account)
            ->with('budget', $budget);
    }

    public function update(Budget $budget, Account $account)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('accounts.edit', [$budget->id, $account->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $account->name = Input::get('name');
        $account->save();

        // redirect
        Session::flash('message', 'Successfully updated account!');
        return redirect()->route('accounts.show', [$budget->id, $account->id]);
    }

    public function destroy(Budget $budget, Account $account)
    {
        $account->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the account!');
        return redirect()->route('sheet', [$budget->id]);
    }

}
