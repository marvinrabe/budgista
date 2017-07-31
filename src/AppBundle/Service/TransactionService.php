<?php

namespace AppBundle\Service;

use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Payee;
use AppBundle\Entity\Transaction;

class TransactionService
{

    public function __construct()
    {

    }

    public function createTransaction(Account $account, Money $amount, Category $category = null, Payee $payee = null): Transaction
    {
        $transaction = new Transaction($account, $amount);
        if ($category !== null) {
            $transaction->setCategory($category);
        }
        if ($payee !== null) {
            $transaction->setPayee($payee);
        }
        return $transaction;
    }

}