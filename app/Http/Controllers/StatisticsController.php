<?php


namespace App\Http\Controllers;

use App\Budget\Month;
use Carbon\Carbon;
use Inertia\Inertia;

class StatisticsController extends Controller
{

    public function __invoke()
    {
        $data = [];
        foreach ($this->months() as $month) {
            $data[] = [
                'month' => (string) $month,
                'worth' => (int) Auth()->user()->transactions()
                    ->where('date', '<=', $month->lastDay())
                    ->sum('amount'),
                'income' => (int) Auth()->user()->transactions()
                    ->whereBetween('date', [$month->firstDay(), $month->lastDay()])
                    ->whereNull('category_id')
                    ->sum('amount'),
                'expense' => abs(Auth()->user()->transactions()
                    ->whereBetween('date', [$month->firstDay(), $month->lastDay()])
                    ->whereNotNull('category_id')
                    ->sum('amount'))
            ];
        }

        return Inertia::render('Statistics', [
            'data' => $data
        ]);
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
