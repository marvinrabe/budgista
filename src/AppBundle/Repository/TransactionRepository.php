<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Account;
use AppBundle\Entity\Transaction;

interface TransactionRepository
{

    public function save(Transaction $transaction): void;

    public function remove(Transaction $transaction): void;

    /**
     * @param Account $account
     * @return Transaction[]
     */
    public function findAllByAccount(Account $account);

}
