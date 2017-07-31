<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table(name="budget")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\BudgetRepository")
 */
class Budget
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
     * @var Month
     *
     * @ORM\Embedded(class="Month")
     */
    protected $date;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money")
     */
    protected $money; // TODO find better name

    public function __construct(Month $date, Category $category, Money $money)
    {
        if (!$money->isPositive()) {
            throw new \InvalidArgumentException('Money has to be positive.');
        }
        $this->date = $date;
        $this->category = $category;
        $this->money = $money;
    }

}