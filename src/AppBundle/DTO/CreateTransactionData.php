<?php


namespace AppBundle\DTO;

use AppBundle\Entity\Account;

class CreateTransactionData
{

    public $date;
    public $payee;
    public $category;
    public $amount;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

}