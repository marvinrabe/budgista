<?php

namespace AppBundle\Command;

use AppBundle\Entity\CategoryBudget;

class UpdateCategoryBudgetCommand
{

    protected $budget;
    protected $category;
    public $amount;

    public function __construct(CategoryBudget $budget)
    {
        $this->budget = $budget;
        $this->amount = $budget->getBudgeted()->getAmount();
    }

    public function getBudget(): CategoryBudget
    {
        return $this->budget;
    }

}
