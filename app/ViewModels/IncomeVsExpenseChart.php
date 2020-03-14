<?php

namespace App\ViewModels;

use App\Month;
use Spatie\ViewModels\ViewModel;

class IncomeVsExpenseChart extends ViewModel
{
    private Month $start;

    private Month $end;

    public function __construct(Month $start, Month $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function data()
    {
        return Month::range($this->start, $this->end)->map(function (Month $month) {
            return [
                'month' => (string) $month,
                'income' => (int) Auth()->user()->transactions()
                    ->noTransfers()
                    ->inMonth($month)
                    ->whereNull('category_id')
                    ->sum('amount'),
                'expense' => abs(Auth()->user()->transactions()
                    ->noTransfers()
                    ->inMonth($month)
                    ->whereNotNull('category_id')
                    ->sum('amount'))
            ];
        });
    }
}
