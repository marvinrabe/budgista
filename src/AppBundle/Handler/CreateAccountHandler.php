<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Entity\Account;
use AppBundle\Repository\AccountRepository;

class CreateAccountHandler
{

    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param CreateAccountCommand $command
     */
    public function handle(CreateAccountCommand $command)
    {
        if ($this->accountRepository->exists($command->name)) {
            throw new \InvalidArgumentException('Account with name "' . $command->name . '" already exists.');
        }

        $account = new Account($command->name);

        /* TODO how to add initial transaction?
         * $transactionData = new CreateTransactionCommand($account);
         * $transactionData->category = 'Income';
         * $transactionData->payee = 'Reconciliation';
         * $transactionData->amount = $balance;
         */

        $this->accountRepository->save($account);
    }

}