<?php

namespace App\AutoBudget;

use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;

class Forecast
{

    /**
     * @var Budget $budget
     */
    protected $budget;

    protected $weights = [];

    protected $unit = 0;

    protected $funds = 0;

    public static function forCategory($category_id)
    {
        $category = Category::find($category_id);

        $forecast = new self($category->budget);

        return $forecast->getBudget($category);
    }

    protected function __construct(Budget $budget)
    {
        $this->budget = $budget;

        $this->funds = $this->calculateFunds();
        $this->weights = $this->calculateWeights();

        $totalWeight = array_reduce($this->weights, function ($carry, $item) {
            $carry += $item;
            return $carry;
        });

        $this->unit = $totalWeight == 0 ? 0 : $this->funds / $totalWeight;
    }

    protected function calculateWeights()
    {
        $weights = [];
        foreach ($this->budget->categories as $category) {
            $weights[$category->id] = $this->calculateWeight($category);
        }
        return $weights;
    }

    protected function calculateWeight(Category $category)
    {
        $oldTransactionsSum = $category->transactions()->where('date', '<', Carbon::now()->firstOfMonth())->sum('amount');

        $firstTransaction = $category->transactions()->orderBy('date', 'asc')->first();

        if($firstTransaction == null) {
            return 0;
        }

        $firstTransactionDate = $firstTransaction->date->firstOfMonth();

        $difference = $firstTransactionDate->diffInMonths(Carbon::now()->lastOfMonth());

        return $difference == 0 ? 0 : $oldTransactionsSum / $difference;
    }

    protected function calculateFunds()
    {
        $sum = 0;
        foreach($this->budget->accounts as $account) {
            $sum += $account->transactions()->whereBetween('date', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->whereNull('category_id')->sum('amount');
        }
        return $sum;
    }

    public function getFunds()
    {
        return $this->funds;
    }

    public function getBudget($category)
    {
        return round($this->weights[$category->id] * $this->unit,2);
    }

}