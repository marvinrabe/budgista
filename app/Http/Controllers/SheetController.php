<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Month;
use Illuminate\Support\Facades\View;

class SheetController extends Controller
{

    public function index(Budget $budget, $month = null)
    {
        if ($month === null) {
            $month = Month::current();
        } else {
            $month = Month::fromString($month);
        }

        return View::make('sheet.index')
            ->with('budget', $budget)
            ->with('month', $month);
    }

}
