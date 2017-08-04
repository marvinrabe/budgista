<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\CreateTransactionCommand;
use AppBundle\Entity\Account;
use AppBundle\Repository\AccountRepository;
use League\Tactician\CommandBus;

class CreateAccountHandler
{

    protected $commandBus;
    protected $accountRepository;

    public function __construct(CommandBus $commandBus, AccountRepository $accountRepository)
    {
        $this->commandBus = $commandBus;
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
        $this->accountRepository->save($account);

        $transactionData = new CreateTransactionCommand($account);
        $transactionData->payee = 'Reconciliation';
        $transactionData->amount = $command->initialBalance;
        $this->commandBus->handle($transactionData);
    }

}
