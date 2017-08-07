<?php

namespace AppBundle\Command;

class CreateTransactionCommand
{

    public $account;

    /**
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2099-12-31"
     * )
     */
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
