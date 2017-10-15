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

    public function show(Budget $budget)
    {
        $budget->updated_at = Carbon::now();
        $budget->save(['timestamps' => FALSE]);

        Auth::user()->activeBudget()->associate($budget)->save();

        return view('budgets.show')->with(compact('budget'));
    }

}
