<?php

namespace AppBundle\Service;

use AppBundle\DTO\CreateAccountData;
use AppBundle\DTO\CreateTransactionData;
use AppBundle\DTO\EditAccountData;
use AppBundle\Entity\Account;
use AppBundle\Entity\Transaction;
use AppBundle\Repository\AccountRepository;

class AccountService
{

    protected $accountRepository;
    protected $transactionService;

    public function __construct(AccountRepository $accountRepository, TransactionService $transactionService)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionService = $transactionService;
    }

    public function createAccount(CreateAccountData $data): Account
    {
        if ($this->accountRepository->exists($data->name)) {
            throw new \InvalidArgumentException('Account with name "' . $data->name . '" already exists.');
        }

        $account = new Account($data->name);

        if ($data->initialBalance > 0) {
            $transaction = $this->getInitialTransaction($data->initialBalance);
            $account->addTransaction($transaction);
        }

        return $account;
    }

    protected function getInitialTransaction(float $balance): Transaction
    {
        $transactionData = new CreateTransactionData();
        $transactionData->category = 'Income';
        $transactionData->payee = 'Reconciliation';
        $transactionData->amount = $balance;

        return $this->transactionService->createTransaction($transactionData);
    }

    public function editAccount(EditAccountData $data): Account
    {
        $account = $this->accountRepository->find($data->id);

        if ($this->accountRepository->exists($data->name) && $account->getName() != $data->name) {
            throw new \InvalidArgumentException('Account with name "' . $data->name . '" already exists.');
        }

        $account->setName($data->name);

        return $account;
    }

}