<?php

namespace App\ViewModels;

use App\Month;
use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Spatie\ViewModels\ViewModel;

class Budget extends ViewModel
{

    protected Month $month;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    public function month()
    {
        return $this->month->toArray();
    }

    public function categories()
    {
        return Auth::user()
            ->categories()
            ->with(['budgets' => fn($query) => $query->where('month', $this->month)])
            ->get()
            ->map(function (Category $category) {
                $budget = $category->budget($this->month);

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'budget' => (int) $budget->amount,
                    'activity' => (int) $budget->activity,
                    'available' => (int) $budget->available,
                    'links' => [
                        'show' => URL::route('budget.show', [
                            'month' => $this->month,
                            'category' => $category
                        ], false)
                    ]
                ];
            });
    }

    public function previousMonth()
    {
        $budgeted = Auth::user()
            ->budgets()
            ->where('month', '<', $this->month->value())
            ->sum('amount');

        $transactions = Auth::user()
            ->transactions()
            ->whereHas('account', function (Builder $query) {
                $query->where('tracking', false);
            })
            ->where('date', '<=', $this->month->previous()->lastDay())
            ->whereNull('category_id')
            ->sum('amount');

        return $transactions - $budgeted;
    }

    public function income()
    {
        return Auth::user()
            ->transactions()
            ->whereHas('account', function (Builder $query) {
                $query->where('tracking', false);
            })
            ->whereNull('category_id')
            ->income()
            ->inMonth($this->month)
            ->sum('amount');
    }

    public function expenses()
    {
        return Auth::user()
            ->transactions()
            ->whereHas('account', function (Builder $query) {
                $query->where('tracking', false);
            })
            ->whereNull('category_id')
            ->expenses()
            ->inMonth($this->month)
            ->sum('amount');
    }

    public function allocated()
    {
        return Auth::user()->budgets()
            ->where('month', $this->month->value())
            ->sum('amount');
    }

    public function available()
    {
        return $this->previousMonth() + $this->income() - $this->allocated() - $this->expenses();
    }

    public function links()
    {
        return [
            'uncategorized' => URL::route('budget.uncategorized', ['month' => $this->month], false),
            'prev' => URL::route('budget', ['month' => $this->month->previous()]),
            'next' => URL::route('budget', ['month' => $this->month->next()])
        ];
    }

}
