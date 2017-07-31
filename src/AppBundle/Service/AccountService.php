<?php

namespace AppBundle\Service;

use AppBundle\Command\CreateTransactionCommand;
use AppBundle\Entity\Account;
use AppBundle\Repository\AccountRepository;

class AccountService
{

    protected $commandBus;
    protected $accountRepository;

    public function __construct(CommandBus $commandBus, AccountRepository $accountRepository)
    {
        $this->commandBus = $commandBus;
        $this->accountRepository = $accountRepository;
    }

    public function createAccount(string $name, float $initialBalance = 0): Account
    {
        if ($this->accountRepository->exists($name)) {
            throw new \InvalidArgumentException('Account with name "' . $name . '" already exists.');
        }

        $account = new Account($name);

        if ($initialBalance > 0) {
            $this->createInitialTransaction($account, $data->initialBalance);
        }

        return $account;
    }

    protected function createInitialTransaction(Account $account, float $balance): void
    {
        $transactionData = new CreateTransactionCommand($account);
        $transactionData->category = 'Income';
        $transactionData->payee = 'Reconciliation';
        $transactionData->amount = $balance;

        $this->commandBus->execute($transactionData);
    }

    public function updateAccountSettings(string $id, string $name): Account
    {
        $account = $this->accountRepository->find($id);

        if ($this->accountRepository->exists($name) && $account->getName() != $name) {
            throw new \InvalidArgumentException('Account with name "' . $name . '" already exists.');
        }

        $account->setName($name);

        return $account;
    }

}