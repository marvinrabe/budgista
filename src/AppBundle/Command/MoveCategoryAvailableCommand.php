<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class MoveCategoryAvailableCommand
{

    /**
     * @Assert\Type("string")
     */
    public $month;

    /**
     * @Assert\Uuid
     */
    public $fromCategory;

    /**
     * @Assert\Uuid
     */
    public $toCategory;

    /**
     * @Assert\Type("double")
     */
    public $amount;

}
