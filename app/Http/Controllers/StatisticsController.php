<?php


namespace App\Http\Controllers;

use App\Month;
use App\ViewModels\ExpenseChart;
use App\ViewModels\IncomeChart;
use App\ViewModels\IncomeVsExpenseChart;
use App\ViewModels\NetWorthChart;
use Carbon\Carbon;
use Inertia\Inertia;

class StatisticsController extends Controller
{

    public function index()
    {
        return Inertia::render('Statistics/Index');
    }

    public function netWorth()
    {
        return Inertia::render(
            'Statistics/NetWorth',
            new NetWorthChart($this->months())
        );
    }

    public function incomeVsExpense()
    {
        return Inertia::render(
            'Statistics/IncomeVsExpense',
            new IncomeVsExpenseChart($this->months())
        );
    }

    public function expense()
    {
        return Inertia::render(
            'Statistics/Expense',
            new ExpenseChart(
                Month::fromString(Carbon::now()->subMonthsNoOverflow(11)->format('Y-m')),
                Month::current()
            )
        );
    }

    public function income()
    {
        return Inertia::render(
            'Statistics/Income',
            new IncomeChart(
                Month::fromString(Carbon::now()->subMonthsNoOverflow(11)->format('Y-m')),
                Month::current()
            )
        );
    }

    /**
     * @return iterable|Month[]
     */
    protected function months()
    {
        return Month::range(
            Month::fromString(Carbon::now()->subMonthsNoOverflow(11)->format('Y-m')),
            Month::current()
        );
    }

}
