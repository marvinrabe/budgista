<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Month;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @Route("/budget")
 */
class BudgetController extends Controller
{

    /**
     * @Route("/{month}", name="budget_list")
     * @Method({"GET"})
     */
    public function listAction(Request $request, Month $month)
    {

        return $this->render('list/budget.html.twig', [
            'month' => $month
        ]);
    }

}
