<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Support\Facades\View;

class SheetController extends Controller
{

    public function index(Budget $budget, $month = null)
    {
        return View::make('sheet.index')
            ->with('budget', $budget)
            ->with('month', $month);
    }

}
