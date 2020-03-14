<?php

namespace App\Http\Controllers;

use App\Month;
use App\ViewModels\ExpenseChart;
use App\ViewModels\IncomeChart;
use App\ViewModels\IncomeVsExpenseChart;
use App\ViewModels\NetWorthChart;
use Carbon\Carbon;
use Inertia\Inertia;

class ReportsController extends Controller
{

    public function __invoke()
    {
        $start = Month::fromString(
            Carbon::now()->subMonthsNoOverflow(11)->format('Y-m')
        );
        $end = Month::current();

        return Inertia::render('Reports', [
            'netWorth' => new NetWorthChart($start, $end),
            'incomeVsExpense' => new IncomeVsExpenseChart($start, $end),
            'income' => new IncomeChart($start, $end),
            'expense' => new ExpenseChart($start, $end)
        ]);
    }

}
