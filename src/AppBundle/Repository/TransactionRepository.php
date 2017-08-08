<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Budget\Account;
use AppBundle\Entity\Budget\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use AppBundle\Entity\Budget\Transaction;

interface TransactionRepository
{

    public function add(Transaction $transaction): void;

    public function remove(Transaction $transaction): void;

    /**
     * @param Account $account
     * @return Transaction[]
     */
    public function findAllByAccount(Account $account);

    public function sumActivity(?Category $category, Month $month): Money;

    public function sumPreviousActivity(?Category $category, Month $month): Money;

}
