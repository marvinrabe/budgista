<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Money
 *
 * @ORM\Embeddable
 */
class Money
{

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=16, scale=2)
     */
    protected $amount;

    public function __construct(string $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function isPositive(): bool
    {
        return $this->amount >= 0;
    }

    public function isNegative(): bool
    {
        return $this->amount <= 0;
    }

}