<?php

namespace AppBundle\Controller;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\UpdateAccountSettingsCommand;
use AppBundle\Entity\Account;
use AppBundle\Form\Type\AccountEditType;
use AppBundle\Repository\AccountRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\AccountNewType;

/**
 * Class AccountController
 * @Route("/account")
 */
class AccountController extends Controller
{

    /**
     * @Route("/", name="account_list")
     * @Method({"GET", "POST"})
     */
    public function listAction(Request $request, CommandBus $commandBus, AccountRepository $repository)
    {
        $data = new CreateAccountCommand();
        $form = $this->createForm(AccountNewType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($data);
        }

        $accounts = $repository->findAll();

        return $this->render('list/account.html.twig', [
            'accounts' => $accounts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="account_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommandBus $commandBus, Account $account)
    {
        $data = new UpdateAccountSettingsCommand();
        $data->id = $account->getId();
        $data->name = $account->getName();

        $form = $this->createForm(AccountEditType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commandBus->handle($data);

            return $this->redirectToRoute('account_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
