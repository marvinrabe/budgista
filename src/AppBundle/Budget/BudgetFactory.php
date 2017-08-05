<?php

namespace AppBundle\Budget;

use AppBundle\Entity\Money;
use AppBundle\Repository\CategoryBudgetRepository;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\TransactionRepository;

class BudgetFactory
{

    protected $categoryRepository;
    protected $categoryBudgetRepository;
    protected $transactionRepository;

    public function __construct(CategoryRepository $categoryRepository, CategoryBudgetRepository $categoryBudgetRepository, TransactionRepository $transactionRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryBudgetRepository = $categoryBudgetRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function get($month): Budget
    {
        $sheet = $this->buildSheet($month);

        $categories = $this->categoryRepository->findAll();
        foreach ($categories as $category) {
            $row = $this->buildRow($category, $month);
            $sheet->add($row);
        }

        return $sheet;
    }

    protected function buildSheet($month)
    {
        $sheet = new Budget($month);

        $previousMonthFunds = $this->transactionRepository->sumPreviousActivity(null, $month);
        $previousMonthBudgeted = $this->categoryBudgetRepository->getAllPreviousBudgeted($month);

        $previousMonth = Money::sum($previousMonthFunds, $previousMonthBudgeted);
        $sheet->setPreviousMonthAvailable($previousMonth);

        $funds = $this->transactionRepository->sumActivity(null, $month);
        $sheet->setFunds($funds);

        return $sheet;
    }

    protected function buildRow($category, $month)
    {
        $previousMonthBudgets = $this->categoryBudgetRepository->getPreviousBudgeted($category, $month);
        $previousMonthTransactions = $this->transactionRepository->sumPreviousActivity($category, $month);
        $previousMonth = Money::sum($previousMonthBudgets, $previousMonthTransactions);

        $budgeted = $this->categoryBudgetRepository->getBudgeted($category, $month);
        $activity = $this->transactionRepository->sumActivity($category, $month);

        return new BudgetRow($category, $previousMonth, $budgeted, $activity);
    }

}
