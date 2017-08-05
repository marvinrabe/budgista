<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Entity\Transaction;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class TransactionRepository implements \AppBundle\Repository\TransactionRepository
{

    protected $em;

    public function __construct(EntityManager $em)
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
        $query = $this->em->createQuery('SELECT t FROM AppBundle\Entity\Transaction t WHERE t.account = ?1 ORDER BY t.date DESC');
        $query->setParameter(1, $account);

        return $query->getResult();
    }

    public function sumActivity(?Category $category, Month $month): Money
    {
        if ($category === null) {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category is null AND t.date >= ?2 AND t.date <= ?3";
            $balance = $this->em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->setParameter(3, $month->lastDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category = ?1 AND t.date >= ?2 AND t.date <= ?3";
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
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category is null AND t.date < ?2";
            $balance = $this->em->createQuery($dql)
                ->setParameter(2, $month->firstDay())
                ->getSingleScalarResult();
        } else {
            $dql = "SELECT SUM(t.cashflow.amount) AS balance FROM AppBundle\Entity\Transaction t WHERE t.category = ?1 AND t.date < ?2";
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
