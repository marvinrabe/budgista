<?php


namespace AppBundle\Domain\Repository;

use AppBundle\Entity\Budget\Category;
use AppBundle\Entity\Budget\CategoryBudget;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;

interface CategoryBudgetRepository
{

    public function add(CategoryBudget $budget): void;

    public function remove(CategoryBudget $budget): void;

    public function getBudgeted(Category $category, Month $month): Money;

    public function getPreviousBudgeted(Category $category, Month $month): Money;

    public function getAllPreviousBudgeted(Month $month): Money;

    public function findOrCreate(Category $category, Month $month): CategoryBudget;

}
