<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Entity\Budget\Category;
use AppBundle\Domain\Repository\CategoryRepository;

class CreateCategoryHandler
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

        $this->categoryRepository->add($category);
    }

}
