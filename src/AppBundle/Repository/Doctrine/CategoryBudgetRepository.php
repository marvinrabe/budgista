<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Category;
use AppBundle\Entity\CategoryBudget;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class CategoryBudgetRepository extends EntityRepository implements \AppBundle\Repository\CategoryBudgetRepository
{

    public function add(CategoryBudget $budget): void
    {
        $this->_em->persist($budget);
    }

    public function remove(CategoryBudget $budget): void
    {
        $this->_em->remove($budget);
    }

    public function getBudgeted(Category $category, Month $month): Money
    {
        /**
         * @var CategoryBudget $budget ;
         */
        $budget = $this->findOneBy(['category' => $category, 'date.month' => $month->getMonth(), 'date.year' => $month->getYear()]);

        if ($budget === null) {
            return new Money(0);
        }

        return $budget->getBudgeted();
    }

    public function getPreviousBudgeted(Category $category, Month $month): Money
    {
        $dql = "SELECT SUM(b.budgeted.amount) AS balance FROM AppBundle\Entity\CategoryBudget b WHERE ((b.date.year = ?1 AND b.date.month < ?2) OR (b.date.year < ?1)) AND b.category = ?3";
        $balance = $this->_em->createQuery($dql)
            ->setParameter(1, $month->getYear())
            ->setParameter(2, $month->getYear())
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
        $balance = $this->_em->createQuery($dql)
            ->setParameter(1, $month->getYear())
            ->setParameter(2, $month->getMonth())
            ->getSingleScalarResult();

        if($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }
}
