<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $budget = Auth::user()->activeBudget;

        if ($budget === null || Auth::user()->cant('view', $budget)) {
            return redirect()->route('budgets.index');
        }

        return redirect()->route('budgets.show', $budget);
    }

}
