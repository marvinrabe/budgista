<?php

namespace App;

use App\Models\Budget;
use App\Models\CategoryBudget;
use JsonSerializable;

class Sheet implements JsonSerializable
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
        $budgeted = CategoryBudget::inBudget($this->budget)->where('month', '<', (string)$this->month)->sum('amount');
        $funds = 0;
        foreach ($this->budget->accounts as $account) {
            $funds += $account->transactions()->where('date', '<=', $this->month->previous()->lastDay())->whereNull('category_id')->sum('amount');
        }
        return $funds - $budgeted;
    }

    public function getFunds()
    {
        $sum = 0;
        foreach ($this->budget->accounts as $account) {
            $sum += $account->transactions()->whereBetween('date', [$this->month->previous()->lastDay(), $this->month->lastDay()])->whereNull('category_id')->sum('amount');
        }
        return $sum;
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'month' => (string)$this->month,
            'previousMonth' => (double)$this->getPreviousMonthAvailable(),
            'budgeted' => (double)$this->getBudgeted(),
            'funds' => (double)$this->getFunds(),
            'available' => (double)$this->getAvailable(),
            'rows' => $this->rows
        ];
    }
}
