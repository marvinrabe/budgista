<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::user()->active_budget_id == null) {
            return redirect()->route('budgets.index');
        }

        return redirect()->route('sheet', [Auth::user()->active_budget_id]);
    }

}
