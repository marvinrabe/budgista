<?php


namespace App\Http\Controllers;

use App\Budget\Month;
use Carbon\Carbon;

class StatisticController extends Controller
{

    public function monthly()
    {
        $data = [];
        foreach ($this->months() as $month) {
            $data[(string)$month] = [
                'worth' => (int)Auth()->user()->transactions()
                    ->where('date', '<=', $month->lastDay())
                    ->sum('amount'),
                'income' => (int)Auth()->user()->transactions()
                    ->whereBetween('date', [$month->firstDay(), $month->lastDay()])
                    ->whereNull('category_id')
                    ->sum('amount'),
                'expense' => abs(Auth()->user()->transactions()
                    ->whereBetween('date', [$month->firstDay(), $month->lastDay()])
                    ->whereNotNull('category_id')
                    ->sum('amount'))
            ];
        }

        return [
            'data' => $data
        ];
    }

    /**
     * @return Month[]
     */
    protected function months()
    {
        $months = [];
        for ($i = 0; $i <= 11; $i++) {
            $months[] = Month::fromString(Carbon::now()->subMonth($i)->format('Y-m'));
        }
        return $months;
    }

}
