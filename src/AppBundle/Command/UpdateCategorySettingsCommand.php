<?php

namespace AppBundle\Command;

use AppBundle\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCategorySettingsCommand
{

    /**
     * @Assert\Uuid
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->name = $category->getName();
    }

}
