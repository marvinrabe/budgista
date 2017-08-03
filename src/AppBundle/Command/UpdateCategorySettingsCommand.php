<?php

namespace AppBundle\Command;

use AppBundle\Entity\Category;

class UpdateCategorySettingsCommand
{

    public $id;
    public $name;

    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->name = $category->getName();
    }

}
