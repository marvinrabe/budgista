<?php

namespace AppBundle\Handler;

use AppBundle\Command\UpdateCategoryBudgetCommand;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Repository\CategoryBudgetRepository;
use AppBundle\Repository\CategoryRepository;

class UpdateCategoryBudgetHandler
{

    protected $categoryRepository;
    protected $categoryBudgetRepository;

    public function __construct(CategoryRepository $categoryRepository, CategoryBudgetRepository $categoryBudgetRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryBudgetRepository = $categoryBudgetRepository;
    }

    /**
     * @param UpdateCategoryBudgetCommand $command
     */
    public function handle(UpdateCategoryBudgetCommand $command)
    {
        $category = $this->categoryRepository->find($command->category);

        if ($category === null) {
            throw new \InvalidArgumentException('Category not found.');
        }

        $month = Month::fromString($command->month);

        $budget = $this->categoryBudgetRepository->findOrCreate($category, $month);

        $money = new Money($command->amount);
        $budget->setBudgeted($money);

        $this->categoryBudgetRepository->add($budget);
    }

}
