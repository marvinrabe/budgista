<?php


namespace AppBundle\Service;

use AppBundle\DTO\CreateAccountData;
use AppBundle\DTO\CreateTransactionData;
use AppBundle\Entity\Account;
use AppBundle\Entity\Transaction;
use AppBundle\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;

class AccountService
{

    protected $em;
    protected $accountRepository;
    protected $transactionService;

    public function __construct(EntityManager $em, AccountRepository $accountRepository, TransactionService $transactionService)
    {
        $this->em = $em;
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
            $this->em->persist($account);
        }

        $this->em->persist($account);

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

}