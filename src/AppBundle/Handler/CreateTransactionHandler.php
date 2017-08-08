<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateTransactionCommand;
use AppBundle\Entity\Money;
use AppBundle\Entity\Budget\Transaction;
use AppBundle\Repository\AccountRepository;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\PayeeRepository;
use AppBundle\Repository\TransactionRepository;
use AppBundle\Domain\Manager\TransactionManager;

class CreateTransactionHandler
{

    protected $accountRepository;
    protected $categoryRepository;
    protected $transactionManager;

    public function __construct(AccountRepository $accountRepository, CategoryRepository $categoryRepository, TransactionManager $transactionManager)
    {
        $this->accountRepository = $accountRepository;
        $this->categoryRepository = $categoryRepository;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param CreateTransactionCommand $command
     */
    public function handle(CreateTransactionCommand $command)
    {
        $account = $this->accountRepository->find($command->account);
        if ($account === null) {
            throw new \InvalidArgumentException('Account not found.');
        }

        $cashflow = new Money($command->amount);

        $category = null;
        if ($this->categoryRepository->exists($command->category)) {
            $category = $this->categoryRepository->findByName($command->category);
        }

        $this->transactionManager->create($account, $command->date, $cashflow, $category, $command->payee);
    }

}
