<?php

namespace AppBundle\Controller;

use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Command\UpdateCategorySettingsCommand;
use AppBundle\Entity\Category;
use AppBundle\Form\Type\CategoryEditType;
use AppBundle\Form\Type\CategoryNewType;
use AppBundle\Repository\CategoryRepository;
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
    public function listAction(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

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
        $form = $this->createForm(CategoryNewType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('command_bus')->handle($data);

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
        $form = $this->createForm(CategoryEditType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('command_bus')->handle($data);

            return $this->redirectToRoute('category_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}