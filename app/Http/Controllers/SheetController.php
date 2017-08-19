<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Month;
use Illuminate\Support\Facades\View;

class SheetController extends Controller
{

    public function index(Budget $budget, $month = null)
    {
        if ($month == null) {
            $currentMonth = Month::current();
            return redirect()->route('sheet', [$budget->id, (string)$currentMonth]);
        }

        $month = Month::fromString($month);

        return View::make('sheet.index')
            ->with('budget', $budget)
            ->with('month', $month);
    }

}
