<?php

namespace App\Http\Controllers;

use App\Account;
use App\Budget;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AccountController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Budget $budget)
    {
        return View::make('accounts.create')
            ->with('budget', $budget);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Budget $budget)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()
                ->route('accounts.create', [$budget->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            // store
            $account = new Account();
            $account->name = Input::get('name');
            $account->budget_id = $budget->id;
            $account->save();

            // redirect
            Session::flash('message', 'Successfully created account!');
            return redirect()->route('accounts.show', [$budget->id, $account->id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Budget $budget, $id)
    {
        $account = Account::findOrFail($id);

        return View::make('accounts.show')
            ->with('account', $account)
            ->with('budget', $budget);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Budget $budget, $id)
    {
        $account = Account::findOrFail($id);

        // show the edit form and pass the nerd
        return View::make('accounts.edit')
            ->with('account', $account)
            ->with('budget', $budget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Budget $budget, $id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()
                ->route('accounts.edit', [$budget->id, $id])
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            // store
            $account = Account::findOrFail($id);
            $account->name = Input::get('name');
            $account->save();

            // redirect
            Session::flash('message', 'Successfully updated account!');
            return redirect()->route('accounts.show', [$budget->id, $account->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Budget $budget, $id)
    {
        // delete
        Account::destroy($id);

        // redirect
        Session::flash('message', 'Successfully deleted the account!');
        return redirect()->route('sheet', [$budget->id]);
    }

}
