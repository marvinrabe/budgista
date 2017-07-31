<?php

namespace AppBundle\Controller;

use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Command\UpdateCategorySettingsCommand;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryEditForm;
use AppBundle\Form\CategoryNewForm;
use AppBundle\Service\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('list/category.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = new CreateCategoryCommand();
        $form = $this->createForm(CategoryNewForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(CommandBus::class)->execute($data);

            return $this->redirectToRoute('category_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $data = new UpdateCategorySettingsCommand($category);
        $form = $this->createForm(CategoryEditForm::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(CommandBus::class)->execute($data);

            return $this->redirectToRoute('category_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}