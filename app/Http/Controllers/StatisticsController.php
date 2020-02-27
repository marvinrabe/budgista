<?php


namespace App\Http\Controllers;

use App\Month;
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

    /**
     * @return Month[]
     */
    protected function months()
    {
        $months = [];
        for ($i = 0; $i <= 11; $i++) {
            $months[] = Month::fromString(Carbon::now()->subMonthNoOverflow(11 - $i)->format('Y-m'));
        }
        return $months;
    }

}
