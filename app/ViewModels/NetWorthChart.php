<?php

namespace App\ViewModels;

use App\Month;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class NetWorthChart extends ViewModel
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
                'worth' => (int) Auth()->user()->transactions()
                    ->noTransfers()
                    ->where('date', '<=', $month->lastDay())
                    ->sum('amount')
            ];
        });
    }
}
