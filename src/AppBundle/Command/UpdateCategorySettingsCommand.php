<?php


namespace AppBundle\Command;

use AppBundle\Entity\Category;

class UpdateCategorySettingsCommand
{

    public $name;

    public function __construct(Category $category)
    {
        $this->name = $category->getName();
    }

}