<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTransactionCommand
{

    /**
     * @Assert\Uuid
     */
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

    /**
     * @Assert\Type("double")
     */
    public $amount;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

}
