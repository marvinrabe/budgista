<?php

namespace AppBundle\Handler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Command\UpdateCategorySettingsCommand;
use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;

class UpdateCategorySettingsHandler
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param UpdateCategorySettingsCommand $command
     */
    public function handle(UpdateCategorySettingsCommand $command)
    {
        $category = $this->categoryRepository->find($command->id);

        if ($category === null) {
            throw new \InvalidArgumentException('Category not found.');
        }

        if ($this->categoryRepository->exists($command->name) && $category->getName() != $command->name) {
            throw new \InvalidArgumentException('Category with name "' . $command->name . '" already exists.');
        }

        $category->setName($command->name);
    }

}
