<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateAccountCommand
{

    /**
     * @Assert\NotBlank()
     */
    public $name;

    public $initialBalance;

}
