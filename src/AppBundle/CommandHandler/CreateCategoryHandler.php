<?php

namespace AppBundle\CommandHandler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;

class CreateCategoryHandler implements Handler
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CreateCategoryCommand $command
     */
    public function handle(CreateCategoryCommand $command)
    {
        if ($this->categoryRepository->exists($command->name)) {
            throw new \InvalidArgumentException('Category with name "' . $command->name . '" already exists.');
        }

        $category = new Category($command->name);

        $this->categoryRepository->save($category);
    }

}