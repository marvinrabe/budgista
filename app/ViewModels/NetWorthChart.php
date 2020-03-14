<?php

namespace App\ViewModels;

use App\Month;
use Spatie\ViewModels\ViewModel;

class NetWorthChart extends ViewModel
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
                'worth' => (int) Auth()->user()->transactions()
                    ->noTransfers()
                    ->where('date', '<=', $month->lastDay())
                    ->sum('amount')
            ];
        });
    }
}
