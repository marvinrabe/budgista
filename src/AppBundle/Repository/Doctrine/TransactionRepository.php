<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Entity\Transaction;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class TransactionRepository extends EntityRepository implements \AppBundle\Repository\TransactionRepository
{

    public function add(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
    }

    public function remove(Transaction $transaction): void
    {
        $this->_em->remove($transaction);
    }

    public function findAllByAccount(Account $account)
    {
        return $this->findBy(['account' => $account], ['date' => 'DESC']);
    }

    public function sumActivity(?Category $category, Month $month): Money
    {
        if($category === null) {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category is null AND t.date >= ?2 AND t.date <= ?3";
            $balance = $this->_em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->setParameter(3, $month->lastDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category = ?1 AND t.date >= ?2 AND t.date <= ?3";
            $balance = $this->_em->createQuery($dql)
                ->setParameter(1, $category)
                ->setParameter(2, $month->firstDay())
                ->setParameter(3, $month->lastDay())
                ->getSingleScalarResult();
        }

        if($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

    public function sumPreviousActivity(?Category $category, Month $month): Money
    {
        if($category === null) {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category is null AND t.date < ?2";
            $balance = $this->_em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category = ?1 AND t.date < ?2";
            $balance = $this->_em->createQuery($dql)
                ->setParameter(1, $category)
                ->setParameter(2, $month->firstDay())
                ->getSingleScalarResult();
        }

        if($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

}
