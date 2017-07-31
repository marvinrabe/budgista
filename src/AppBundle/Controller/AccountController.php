<?php

namespace AppBundle\Controller;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\UpdateAccountSettingsCommand;
use AppBundle\Entity\Account;
use AppBundle\Form\AccountEditForm;
use AppBundle\Service\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AccountNewForm;

/**
 * Class AccountController
 * @Route("/account")
 */
class AccountController extends Controller
{

    /**
     * @Route("/", name="account_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $accounts = $this->getDoctrine()->getRepository(Account::class)->findAll();

        return $this->render('list/account.html.twig', [
            'accounts' => $accounts
        ]);
    }

    /**
     * @Route("/new", name="account_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = new CreateAccountCommand();
        $form = $this->createForm(AccountNewForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(CommandBus::class)->execute($data);

            return $this->redirectToRoute('account_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="account_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Account $account)
    {
        $data = new UpdateAccountSettingsCommand($account);
        $form = $this->createForm(AccountEditForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(CommandBus::class)->execute($data);

            return $this->redirectToRoute('account_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}