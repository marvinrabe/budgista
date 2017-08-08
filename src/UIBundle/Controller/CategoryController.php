<?php

namespace UIBundle\Controller;

use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Command\UpdateCategorySettingsCommand;
use AppBundle\Entity\Budget\Category;
use UIBundle\Form\Type\CategoryEditType;
use UIBundle\Form\Type\CategoryNewType;
use AppBundle\Domain\Repository\CategoryRepository;
use League\Tactician\CommandBus;
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
     * @Method({"GET", "POST"})
     */
    public function listAction(Request $request, CommandBus $commandBus, CategoryRepository $repository)
    {
        $data = new CreateCategoryCommand();
        $form = $this->createForm(CategoryNewType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commandBus->handle($data);

        }

        $categories = $repository->findAll();

        return $this->render('list/category.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommandBus $commandBus, Category $category)
    {
        $data = new UpdateCategorySettingsCommand();
        $data->id = $category->getId();
        $data->name = $category->getName();

        $form = $this->createForm(CategoryEditType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commandBus->handle($data);

            return $this->redirectToRoute('category_list');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
