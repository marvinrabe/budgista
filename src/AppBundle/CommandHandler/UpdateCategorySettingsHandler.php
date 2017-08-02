<?php

namespace AppBundle\CommandHandler;

use AppBundle\Command\CreateAccountCommand;
use AppBundle\Command\CreateCategoryCommand;
use AppBundle\Command\UpdateCategorySettingsCommand;
use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;

class UpdateCategorySettingsHandler implements Handler
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

        if ($this->categoryRepository->exists($command->name) && $category->getName() != $command->name) {
            throw new \InvalidArgumentException('Category with name "' . $command->name . '" already exists.');
        }

        $category->setName($command->name);

        $this->categoryRepository->save($category);
    }

}