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
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $account;

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
    protected $money; // TODO find a better name

    public function __construct(Account $account, Money $amount)
    {
        $this->date = new \DateTime();
        $this->account = $account;
        $this->money = $amount;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Payee
     */
    public function getPayee(): Payee
    {
        return $this->payee;
    }

    /**
     * @param Payee $payee
     */
    public function setPayee(Payee $payee)
    {
        $this->payee = $payee;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @param Money $money
     */
    public function setMoney(Money $money)
    {
        $this->money = $money;
    }

}
