<?php

namespace App\ViewModels;

use App\Month;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\ViewModels\ViewModel;

class IncomeChart extends ViewModel
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
        return DB::table('transactions')
            ->selectRaw('sum(amount) as income')
            ->selectRaw('payee as category')
            ->where('user_id', Auth::id())
            ->where('amount', '>', 0)
            ->whereNull('related_id')
            ->groupBy('payee')
            ->orderByDesc('income')
            ->get();
    }
}
