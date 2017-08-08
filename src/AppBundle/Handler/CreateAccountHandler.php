<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Entity\Money;
use AppBundle\Domain\Manager\AccountManager;

class CreateAccountHandler
{

    protected $accountManager;

    public function __construct(AccountManager $accountManager)
    {
        $this->accountManager = $accountManager;
    }

    /**
     * @param CreateAccountCommand $command
     */
    public function handle(CreateAccountCommand $command)
    {
        $initialBalance = new Money($command->initialBalance);
        $this->accountManager->create($command->name, $initialBalance);
    }

}
