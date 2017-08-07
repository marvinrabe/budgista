<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Transaction;
use AppBundle\Repository\TransactionRepository;

class TransactionManager
{

    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function create(Account $account, \DateTime $date, Money $cashflow, ?Category $category = null, string $payee = null)
    {
        $transaction = new Transaction($account, $cashflow);

        $transaction->setDate($date);

        if ($payee !== null) {
            $transaction->setPayee($payee);
        }

        if ($category !== null) {
            $transaction->setCategory($category);
        }

        $this->transactionRepository->add($transaction);
    }

}
