<?php


namespace AppBundle\DTO;

use AppBundle\Entity\Account;

class EditAccountData
{
    public $id;
    public $name;

    public function __construct(Account $account)
    {
        $this->id = $account->getId();
        $this->name = $account->getName();
    }
}