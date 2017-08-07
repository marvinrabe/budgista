<?php

namespace AppBundle\Handler;

use AppBundle\Command\MoveCategoryAvailableCommand;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Repository\CategoryBudgetRepository;
use AppBundle\Repository\CategoryRepository;

class MoveCategoryAvailableHandler
{

    protected $categoryRepository;
    protected $categoryBudgetRepository;

    public function __construct(CategoryRepository $categoryRepository, CategoryBudgetRepository $categoryBudgetRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryBudgetRepository = $categoryBudgetRepository;
    }

    /**
     * @param MoveCategoryAvailableCommand $command
     */
    public function handle(MoveCategoryAvailableCommand $command)
    {
        $fromCategory = $this->categoryRepository->find($command->fromCategory);

        if ($fromCategory === null) {
            throw new \InvalidArgumentException('Category not found.');
        }

        $toCategory = $this->categoryRepository->find($command->toCategory);

        if ($toCategory === null) {
            throw new \InvalidArgumentException('Category not found.');
        }

        $month = Month::fromString($command->month);

        $moneyA = new Money(-1 * $command->amount);
        $moneyB = new Money($command->amount);

        $budgetA = $this->categoryBudgetRepository->findOrCreate($fromCategory, $month);
        $budgetA->setBudgeted(Money::sum($budgetA->getBudgeted(), $moneyA));
        $this->categoryBudgetRepository->add($budgetA);

        $budgetB = $this->categoryBudgetRepository->findOrCreate($toCategory, $month);
        $budgetB->setBudgeted(Money::sum($budgetB->getBudgeted(), $moneyB));
        $this->categoryBudgetRepository->add($budgetB);

    }

}
