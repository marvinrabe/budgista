<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Month;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="budget")
     * @Method({"GET"})
     */
    public function listAction()
    {
        return $this->redirectToRoute('budget_list', ['month' => (string) Month::current()]);
    }

}
