<?php

namespace App;

use App\Models\Category;
use App\Models\CategoryBudget;
use JsonSerializable;

class Row implements JsonSerializable
{

    protected $category;
    protected $month;

    public function __construct(Category $category, Month $month)
    {
        $this->category = $category;
        $this->month = $month;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPreviousMonth()
    {
        $budgeted = CategoryBudget::where('month', '<', (string) $this->month)->where('category_id', '=', $this->category->id)->sum('amount');
        $activity = $this->category->transactions()->where('date', '<=', $this->month->previous()->lastDay())->sum('amount');
        return $budgeted + $activity;
    }

    public function getBudgeted()
    {
        return $this->category->month($this->month)->amount+0;
    }

    public function getActivity()
    {
        return $this->category->transactions()->whereBetween('date', [$this->month->previous()->lastDay(), $this->month->lastDay()])->sum('amount');
    }

    public function getAvailable()
    {
        return $this->getPreviousMonth() + $this->getBudgeted() + $this->getActivity();
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->category->id,
            'name' => $this->category->name,
            'month' => $this->month,
            'previousMonth' => (double) $this->getPreviousMonth(),
            'budgeted' => (double) $this->getBudgeted(),
            'activity' => (double) $this->getActivity(),
            'available' => (double) $this->getAvailable(),
        ];
    }
}
