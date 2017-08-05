<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Category;
use AppBundle\Entity\CategoryBudget;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use Doctrine\ORM\EntityManager;

class CategoryBudgetRepository implements \AppBundle\Repository\CategoryBudgetRepository
{

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(CategoryBudget $budget): void
    {
        $this->em->persist($budget);
    }

    public function remove(CategoryBudget $budget): void
    {
        $this->em->remove($budget);
    }

    public function getBudgeted(Category $category, Month $month): Money
    {
        $budget = $this->findOrCreate($category, $month);
        return $budget->getBudgeted();
    }

    public function getPreviousBudgeted(Category $category, Month $month): Money
    {
        $dql = "SELECT SUM(b.budgeted.amount) AS balance FROM AppBundle\Entity\CategoryBudget b WHERE ((b.date.year = ?1 AND b.date.month < ?2) OR (b.date.year < ?1)) AND b.category = ?3";
        $balance = $this->em->createQuery($dql)
            ->setParameter(1, $month->getYear())
            ->setParameter(2, $month->getMonth())
            ->setParameter(3, $category)
            ->getSingleScalarResult();

        if($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

    public function getAllPreviousBudgeted(Month $month): Money
    {
        $dql = "SELECT SUM(b.budgeted.amount) AS balance FROM AppBundle\Entity\CategoryBudget b WHERE (b.date.year = ?1 AND b.date.month < ?2) OR (b.date.year < ?1)";
        $balance = $this->em->createQuery($dql)
            ->setParameter(1, $month->getYear())
            ->setParameter(2, $month->getMonth())
            ->getSingleScalarResult();

        if($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

    public function findOrCreate(Category $category, Month $month): CategoryBudget
    {
        /**
         * @var CategoryBudget $budget
         */
        $query = $this->em->createQuery('SELECT b FROM AppBundle\Entity\CategoryBudget b WHERE b.category = ?1 AND b.date.month = ?2 AND b.date.year = ?3');
        $query->setParameter(1, $category);
        $query->setParameter(2, $month->getMonth());
        $query->setParameter(3, $month->getYear());

        $budget = $query->getOneOrNullResult();

        if($budget === null) {
            $budget = new CategoryBudget($category, $month, new Money(0));
        }

        return $budget;
    }

}
