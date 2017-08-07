<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryCommand
{

    /**
     * @Assert\NotBlank()
     */
    public $name;

}
