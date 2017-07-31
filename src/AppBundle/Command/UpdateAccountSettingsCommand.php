<?php

namespace AppBundle\Command;

use AppBundle\Entity\Account;

class UpdateAccountSettingsCommand
{
    public $id;
    public $name;

    public function __construct(Account $account)
    {
        $this->id = $account->getId();
        $this->name = $account->getName();
    }
}