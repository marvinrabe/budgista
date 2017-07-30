<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\AccountRepository")
 */
class Account
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Transaction")
     * @ORM\JoinTable(name="account_transaction",
     *      joinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $transactions = [];

    public function __construct(string $name)
    {
        $this->transactions = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function addTransaction($transaction)
    {
        $this->transactions[] = $transaction;
    }

}