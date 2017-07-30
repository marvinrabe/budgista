<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\TransactionRepository")
 */
class Transaction
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
     * @var \DateTime
     *
     * @ORM\Column(type="date")
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
     * @var Payee
     *
     * @ORM\ManyToOne(targetEntity="Payee")
     * @ORM\JoinColumn(name="payee_id", referencedColumnName="id")
     */
    protected $payee;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money")
     */
    protected $money;

    public function __construct(\DateTime $date, Category $category, Payee $payee, Money $money)
    {
        $this->date = $date;
        $this->category = $category;
        $this->payee = $payee;
        $this->money = $money;
    }

}