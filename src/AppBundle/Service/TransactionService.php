<?php


namespace AppBundle\Service;


use AppBundle\DTO\CreateTransactionData;
use AppBundle\Entity\Money;
use AppBundle\Entity\Transaction;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\PayeeRepository;

class TransactionService
{

    protected $categoryRepository;
    protected $payeeRepository;

    public function __construct(CategoryRepository $categoryRepository, PayeeRepository $payeeRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->payeeRepository = $payeeRepository;
    }

    public function createTransaction(CreateTransactionData $data)
    {
        $category = $this->categoryRepository->findByName($data->category);
        $payee = $this->payeeRepository->findByName($data->payee);
        $money = new Money($data->amount);

        return new Transaction($data->date, $category, $payee, $money);
    }

}