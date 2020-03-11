<?php

namespace App\ViewModels;

use App\Month;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class IncomeVsExpenseChart extends ViewModel
{
    protected $months;

    /**
     * @param  Month[]  $months
     */
    public function __construct($months)
    {
        $this->months = Collection::make($months);
    }

    public function data()
    {
        return $this->months->map(function (Month $month) {
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
