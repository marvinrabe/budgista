<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Month
 *
 * @ORM\Embeddable
 */
class Month
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $month;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $year;

    public function __construct(int $month, int $year)
    {
        if ($month > 12 || $month < 1) {
            throw new \InvalidArgumentException('Value ' . $month . ' for month is invalid.');
        }

        if ($year < 1900 || $year > 2100) {
            throw new \InvalidArgumentException('Value ' . $year . ' for year is invalid.');
        }

        $this->month;
        $this->year;
    }

    public static function current(): Month
    {
        $today = new \DateTime();
        return new Month($today->format('m'), $today->format('Y'));
    }

    public function __toString()
    {
        return $this->year . $this->month;
    }

    public function previousMonth(): Month
    {
        if ($this->month == 1) {
            return new Month(12, $this->year - 1);
        }
        return new Month($this->month - 1, $this->year);
    }

    public function nextMonth(): Month
    {
        if ($this->month == 12) {
            return new Month(1, $this->year + 1);
        }
        return new Month($this->month + 1, $this->year);
    }

}