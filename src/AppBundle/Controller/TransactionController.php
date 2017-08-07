<?php

namespace AppBundle\Controller;

use AppBundle\Command\CreateTransactionCommand;
use AppBundle\Entity\Account;
use AppBundle\Form\Type\TransactionNewType;
use AppBundle\Repository\TransactionRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @Route("/transaction")
 */
class TransactionController extends Controller
{

    /**
     * @Route("/{id}", name="transaction_list")
     * @Method({"GET", "POST"})
     */
    public function listAction(Request $request, CommandBus $commandBus, TransactionRepository $repository, Account $account)
    {
        $data = new CreateTransactionCommand();
        $data->account = $account->getId();

        $form = $this->createForm(TransactionNewType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commandBus->handle($data);

        }

        $transactions = $repository->findAllByAccount($account);

        return $this->render('list/transaction.html.twig', [
            'transactions' => $transactions,
            'form' => $form->createView()
        ]);
    }

}
