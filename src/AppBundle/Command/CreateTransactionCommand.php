<?php

namespace AppBundle\Command;

class CreateTransactionCommand
{

    public $account;
    public $date;
    public $payee;
    public $category;
    public $amount;

    public function __construct($account)
    {
        $this->account = $account;
        $this->date = new \DateTime();
    }

}