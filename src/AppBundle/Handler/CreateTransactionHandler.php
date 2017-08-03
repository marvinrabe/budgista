<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateTransactionCommand;
use AppBundle\Entity\Money;
use AppBundle\Entity\Transaction;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\PayeeRepository;
use AppBundle\Repository\TransactionRepository;

class CreateTransactionHandler
{

    protected $categoryRepository;
    protected $payeeRepository;
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository, PayeeRepository $payeeRepository, CategoryRepository $categoryRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->payeeRepository = $payeeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CreateTransactionCommand $command
     */
    public function handle(CreateTransactionCommand $command)
    {
        $cashflow = new Money($command->amount);
        $transaction = new Transaction($command->account, $cashflow);

        $transaction->setDate($command->date);

        $this->transactionRepository->save($transaction);
    }

}
