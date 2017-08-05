<?php

namespace AppBundle\Handler;

use AppBundle\Command\UpdateCategoryBudgetCommand;
use AppBundle\Entity\Money;
use AppBundle\Repository\CategoryBudgetRepository;

class UpdateCategoryBudgetHandler
{
    protected $categoryBudgetRepository;

    public function __construct(CategoryBudgetRepository $categoryBudgetRepository)
    {
        $this->categoryBudgetRepository = $categoryBudgetRepository;
    }

    /**
     * @param UpdateCategoryBudgetCommand $command
     */
    public function handle(UpdateCategoryBudgetCommand $command)
    {
        $budget = $command->getBudget();

        $money = new Money($command->amount);
        $budget->setBudgeted($money);

        $this->categoryBudgetRepository->add($budget);
    }

}
