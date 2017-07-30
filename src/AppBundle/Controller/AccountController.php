<?php

namespace AppBundle\Controller;

use AppBundle\DTO\CreateAccountData;
use AppBundle\Entity\Account;
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
            $this->get('AppBundle\Service\AccountService')->createAccount();
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
    public function editAction(Account $account)
    {

    }

}