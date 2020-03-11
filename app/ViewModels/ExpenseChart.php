<?php

namespace App\ViewModels;

use App\Month;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\ViewModels\ViewModel;

class ExpenseChart extends ViewModel
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
            ->selectRaw('-1 * sum(amount) as expense')
            ->selectRaw('categories.name as category')
            ->leftJoin('categories', 'transactions.category_id', '=','categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('amount', '<', 0)
            ->whereNull('related_id')
            ->groupBy('categories.name')
            ->orderByDesc('expense')
            ->get();
    }
}
