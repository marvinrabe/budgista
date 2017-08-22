<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::user()->active_budget_id === null) {
            return redirect()->route('budgets.index');
        }

        $budget = Budget::find(Auth::user()->active_budget_id);

        if ($budget === null || Auth::user()->cant('view', $budget)) {
            return redirect()->route('budgets.index');
        }

        return redirect()->route('sheet', [$budget->id]);
    }

}
