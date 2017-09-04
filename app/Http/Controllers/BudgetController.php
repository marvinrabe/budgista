<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Month;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        return View::make('budgets.show')->with('budget', $budget);
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
                ->route('budgets.edit', [$budget->id])
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

    public function month(Budget $budget, $month = null)
    {
        $this->authorize('view', $budget);

        $month = $this->getMonth($month);

        return [
            'data' => $budget->month($month),
            'links' => [
                'prev' => route('budgets.month', [$budget, 'month' => $month->previous()]),
                'next' => route('budgets.month', [$budget, 'month' => $month->next()])
            ]
        ];
    }

    private function getMonth($string)
    {
        try {
            if ($string !== null) {
                return Month::fromString($string);
            }

            return Month::current();
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }

    public function sort(Request $request, Budget $budget)
    {
        $this->authorize('view', $budget);

        $this->validate($request, [
            'categories' => 'required'
        ]);

        foreach(Input::get('categories') as $key => $category_id) {
            $category = Category::find($category_id);
            $category->sort = $key;
            $category->save();
        }

        return [];
    }

}
