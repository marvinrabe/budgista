<?php

namespace App\Budget;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JsonSerializable;

class Sheet implements JsonSerializable
{

    protected $user;
    protected $month;

    /**
     * @var Category[]
     */
    protected $rows = [];

    public function __construct(User $user, Month $month)
    {
        $this->user = $user;
        $this->month = $month;

        $this->rows = $user->categories->map(function($category) use ($month) {
            return $category->budget($month);
        });
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
        $budgeted = $this->getCategoryBudgetSum();
        $funds = 0;
        $accounts = $this->user->accounts()->where('tracking', false)->get();
        foreach ($accounts as $account) {
            $funds += $account->transactions()->where('date', '<=', $this->month->previous()->lastDay())->whereNull('category_id')->sum('amount');
        }
        return $funds - $budgeted;
    }

    private function getCategoryBudgetSum()
    {
        return DB::table('budgets')
            ->join('categories', 'categories.id', '=', 'budgets.category_id')
            ->where([
                ['month', '<', (string)$this->month],
                ['user_id', '=', $this->user->id]
            ])
            ->sum('amount');
    }

    public function getFunds()
    {
        $sum = 0;
        $accounts = $this->user->accounts()->where('tracking', false)->get();
        foreach ($accounts as $account) {
            $sum += $account
                ->transactions()
                ->whereNull('category_id')
                ->whereBetween('date', [$this->month->firstDay(), $this->month->lastDay()])
                ->sum('amount');
        }
        return $sum;
    }

    public function getBudgeted()
    {
        return $this->rows->sum('amount');
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
            'previousMonth' => (int)$this->getPreviousMonthAvailable(),
            'allocated' => (int)$this->getBudgeted(),
            'income' => (int)$this->getFunds(),
            'unallocated' => (int)$this->getAvailable(),
            'rows' => $this->rows
        ];
    }
}
