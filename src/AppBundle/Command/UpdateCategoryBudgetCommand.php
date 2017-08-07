<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateCategoryBudgetCommand
{

    /**
     * @Assert\Type("string")
     */
    public $month;

    /**
     * @Assert\Uuid
     */
    public $category;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\Type("double")
     */
    public $amount;

}
