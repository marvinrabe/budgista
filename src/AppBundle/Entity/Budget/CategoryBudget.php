<?php

namespace AppBundle\Entity\Budget;

use AppBundle\Entity\Budget\Category;
use AppBundle\Entity\Money;
use AppBundle\Entity\Month;
use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table(name="budget")
 * @ORM\Entity()
 */
class CategoryBudget
{

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var Month
     *
     * @ORM\Embedded(class="AppBundle\Entity\Month")
     */
    protected $date;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="AppBundle\Entity\Money")
     */
    protected $budgeted;

    public function __construct(Category $category, Month $date, Money $budgeted)
    {
        $this->category = $category;
        $this->date = $date;
        $this->budgeted = $budgeted;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getMonth(): Month
    {
        return $this->date;
    }

    public function getBudgeted(): Money
    {
        return $this->budgeted;
    }

    public function setBudgeted(Money $budgeted)
    {
        $this->budgeted = $budgeted;
    }

}
