<?php

namespace AppBundle\Command;

use AppBundle\Entity\CategoryBudget;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCategoryBudgetCommand
{

    protected $budget;

    /**
     * @Assert\GreaterThanOrEqual(0)
     */
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
