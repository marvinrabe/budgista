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
        $rules = [
            'name' => 'required',
            'currency' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('budgets.create')
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $budget = Budget::make(request([
            'name', 'currency'
        ]));

        Auth::user()->budgets()->save($budget);

        // redirect
        Session::flash('message', 'Successfully created budget!');
        return redirect()->route('budgets.index');
    }

    public function show(Budget $budget)
    {
        $budget->updated_at = Carbon::now();
        $budget->save(['timestamps' => FALSE]);

        Auth::user()->activeBudget()->associate($budget)->save();

        return view('budgets.show')->with(compact('budget'));
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit')->with(compact('budget'));
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
                ->route('budgets.edit', [$budget->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $budget->name = request('name');
        $budget->currency = request('currency');
        $budget->save();

        Session::flash('message', 'Successfully updated budget!');

        return back();
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();

        Session::flash('message', 'Successfully deleted the budget!');

        return redirect()->route('budgets.index');
    }

}
