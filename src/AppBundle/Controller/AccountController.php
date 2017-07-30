<?php

namespace AppBundle\Controller;

use AppBundle\DTO\CreateAccountData;
use AppBundle\DTO\EditAccountData;
use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\Payee;
use AppBundle\Form\AccountEditForm;
use AppBundle\Service\AccountService;
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
     * @Route("/PREPARE", name="prepare")
     * @Method({"GET"})
     * TODO remove when categroy part is added.
     */
    public function prepareAction()
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category('Income');
        $em->persist($category);

        $payee = new Payee('Reconciliation');
        $em->persist($payee);

        $em->flush();

        return $this->redirectToRoute('account_new');
    }

    /**
     * @Route("/", name="account_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $accounts = $this->getDoctrine()->getRepository(Account::class)->findAll();

        return $this->render('account/list.html.twig', [
            'accounts' => $accounts
        ]);
    }

    /**
     * @Route("/new", name="account_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = new CreateAccountData();
        $form = $this->createForm(AccountNewForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $this->get(AccountService::class)->createAccount($data);

            $this->getDoctrine()->getManager()->persist($account);
            foreach ($account->getTransactions() as $transaction) {
                $this->getDoctrine()->getManager()->persist($transaction);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_list');
        }

        return $this->render('account/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="account_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Account $account)
    {

        $data = new EditAccountData($account);
        $form = $this->createForm(AccountEditForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(AccountService::class)->editAccount($data);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_list');
        }

        return $this->render('account/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}