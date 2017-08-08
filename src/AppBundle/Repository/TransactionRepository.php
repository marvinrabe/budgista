<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Budget\Account;
use AppBundle\Entity\Budget\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Entity\Budget\Transaction;
use Doctrine\ORM\EntityManagerInterface;

class TransactionRepository implements \AppBundle\Domain\Repository\TransactionRepository
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Transaction $transaction): void
    {
        $this->em->persist($transaction);
    }

    public function remove(Transaction $transaction): void
    {
        $this->em->remove($transaction);
    }

    public function findAllByAccount(Account $account)
    {
        $query = $this->em->createQuery('SELECT t FROM AppBundle\Entity\Budget\Transaction t WHERE t.account = ?1 ORDER BY t.date DESC');
        $query->setParameter(1, $account);

        return $query->getResult();
    }

    public function sumActivity(?Category $category, Month $month): Money
    {
        if ($category === null) {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Budget\Transaction t WHERE t.category is null AND t.date >= ?2 AND t.date <= ?3";
            $balance = $this->em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->setParameter(3, $month->lastDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Budget\Transaction t WHERE t.category = ?1 AND t.date >= ?2 AND t.date <= ?3";
            $balance = $this->em->createQuery($dql)
                ->setParameter(1, $category)
                ->setParameter(2, $month->firstDay())
                ->setParameter(3, $month->lastDay())
                ->getSingleScalarResult();
        }

        if ($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

    public function sumPreviousActivity(?Category $category, Month $month): Money
    {
        if ($category === null) {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Budget\Transaction t WHERE t.category is null AND t.date < ?2";
            $balance = $this->em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Budget\Transaction t WHERE t.category = ?1 AND t.date < ?2";
            $balance = $this->em->createQuery($dql)
                ->setParameter(1, $category)
                ->setParameter(2, $month->firstDay())
                ->getSingleScalarResult();
        }

        if ($balance === null) {
            $balance = 0;
        }

        return new Money($balance);
    }

}
