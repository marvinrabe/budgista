<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Account;
use AppBundle\Entity\Money;
use AppBundle\Repository\AccountRepository;
use AppBundle\Service\DomainException;

class AccountManager
{

    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository, TransactionManager $transactionManager)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create(string $name, Money $initialBalance): Account
    {
        if ($this->accountRepository->exists($name)) {
            throw new DomainException('Account with name "' . $name . '" already exists.');
        }

        $account = new Account($name);
        $this->accountRepository->add($account);

        $this->transactionManager->create($account, new \DateTime('now'), $initialBalance, null, 'Reconciliation');

        return $account;
    }

}
