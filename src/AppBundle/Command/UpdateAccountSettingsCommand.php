<?php

namespace AppBundle\Command;

use AppBundle\Entity\Account;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAccountSettingsCommand
{

    /**
     * @Assert\Uuid
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $name;

}
