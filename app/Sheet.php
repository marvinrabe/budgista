<?php

namespace App;

use App\Models\Budget;
use App\Models\CategoryBudget;

class Sheet
{

    protected $budget;
    protected $month;

    /**
     * @var Row[]
     */
    protected $rows = [];

    public function __construct(Budget $budget, Month $month)
    {
        $this->budget = $budget;
        $this->month = $month;

        foreach ($budget->categories as $category) {
            $this->rows[] = new Row($category, $month);
        }
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getPreviousMonthAvailable()
    {
        $budgeted = CategoryBudget::where('month', '<', (string) $this->month)->sum('amount');
        $funds = $this->budget->transactions()->where('date', '<=', $this->month->previous()->lastDay())->whereNull('category_id')->sum('amount');
        return $funds - $budgeted;
    }

    public function getFunds()
    {
        return $this->budget->transactions()->whereBetween('date', [$this->month->previous()->lastDay(), $this->month->lastDay()])->whereNull('category_id')->sum('amount');
    }

    public function getBudgeted()
    {
        $sum = 0;
        foreach ($this->rows as $row) {
            $sum += $row->getBudgeted();
        }
        return $sum;
    }

    public function getAvailable()
    {
        return $this->getPreviousMonthAvailable() + $this->getFunds() - $this->getBudgeted();
    }

}
