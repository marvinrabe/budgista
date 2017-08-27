<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BudgetController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Budget::class);
    }

    public function index()
    {
        return View::make('budgets.index')
            ->with('budgets', Auth::user()->budgets);
    }

    public function create()
    {
        return View::make('budgets.create');
    }

    public function store()
    {
        $rules = array(
            'name' => 'required',
            'currency' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('budgets.create')
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $budget = new Budget;
        $budget->name = Input::get('name');
        $budget->currency = Input::get('currency');
        $budget->user_id = Auth::user()->id;
        $budget->save();

        // redirect
        Session::flash('message', 'Successfully created budget!');
        return redirect()->route('budgets.index');
    }

    public function show(Budget $budget)
    {
        $budget->updated_at = Carbon::now();
        $budget->save(['timestamps' => FALSE]);

        Auth::user()->active_budget_id = $budget->id;
        Auth::user()->save();

        return redirect()->route('sheet', ['budget' => $budget->id]);
    }

    public function edit(Budget $budget)
    {
        return View::make('budgets.edit')
            ->with('budget', $budget);
    }

    public function update(Budget $budget)
    {
        $rules = array(
            'name' => 'required',
            'currency' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('budgets.edit', [$id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $budget->name = Input::get('name');
        $budget->currency = Input::get('currency');
        $budget->save();

        Session::flash('message', 'Successfully updated budget!');
        return redirect()->route('budgets.index');
    }

    public function delete(Budget $budget)
    {
        // Remove as active budget.
        if (Auth::user()->active_budget_id == $budget->id) {
            Auth::user()->active_budget_id = null;
            Auth::user()->save();
        }

        $budget->delete();

        Session::flash('message', 'Successfully deleted the budget!');
        return redirect()->route('budgets.index');
    }

}
