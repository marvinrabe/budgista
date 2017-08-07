<?php

namespace AppBundle\Controller;

use AppBundle\Command\MoveCategoryAvailableCommand;
use AppBundle\Form\Type\BudgetMoveType;
use AppBundle\Query\BudgetFactory;
use AppBundle\Command\UpdateCategoryBudgetCommand;
use AppBundle\Entity\Category;
use AppBundle\Entity\Month;
use AppBundle\Form\Type\BudgetEditType;
use AppBundle\Repository\CategoryBudgetRepository;
use League\Tactician\CommandBus;
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
    public function listAction(Month $month, BudgetFactory $factory)
    {
        $budget = $factory->get($month);

        return $this->render('list/budget.html.twig', [
            'budget' => $budget
        ]);
    }

    /**
     * @Route("/{month}/{category}", name="budget_edit")
     * @Method({"GET", "POST"})
     */
    public function updateBudgetAction(Request $request, CommandBus $commandBus, CategoryBudgetRepository $repository, Month $month, Category $category)
    {
        $budget = $repository->findOrCreate($category, $month);

        $data = new UpdateCategoryBudgetCommand();
        $data->category = $category->getId();
        $data->month = (string) $month;
        $data->amount = $budget->getBudgeted()->getAmount();

        $form = $this->createForm(BudgetEditType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($data);

            return $this->redirectToRoute('budget_list', ['month' => (string)$month]);
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{month}/{category}/moveAvailable", name="budget_moveAvailable")
     * @Method({"GET", "POST"})
     */
    public function moveAvailableAction(Request $request, CommandBus $commandBus, CategoryBudgetRepository $repository, Month $month, Category $category)
    {
        $data = new MoveCategoryAvailableCommand();
        $data->month = (string) $month;
        $data->fromCategory = $category->getId();

        $form = $this->createForm(BudgetMoveType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($data);

            return $this->redirectToRoute('budget_list', ['month' => (string)$month]);
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
