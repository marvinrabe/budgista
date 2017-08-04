<?php

namespace AppBundle\Budget;

use AppBundle\Entity\Category;
use AppBundle\Entity\Money;

class BudgetRow
{

    protected $category;
    protected $previousMonth;
    protected $budgeted;
    protected $activity;

    public function __construct(Category $category, Money $previousMonth, Money $budgeted, Money $activity)
    {
        $this->category = $category;
        $this->previousMonth = $previousMonth;
        $this->budgeted = $budgeted;
        $this->activity = $activity;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPreviousMonth(): Money
    {
        return $this->previousMonth;
    }

    public function getBudgeted(): Money
    {
        return $this->budgeted;
    }

    public function getActivity(): Money
    {
        return $this->activity;
    }

    public function getAvailable(): Money
    {
        return Money::sum($this->previousMonth, $this->budgeted, $this->activity);
    }

}
