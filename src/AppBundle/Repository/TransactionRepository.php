<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Transaction;

interface TransactionRepository
{

    public function save(Transaction $transaction): void;

    public function remove(Transaction $transaction): void;

}