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

        if ($year < 1900 || $year >= 2100) {
            throw new \InvalidArgumentException('Value ' . $year . ' for year is invalid.');
        }

        $this->month = $month;
        $this->year = $year;
    }

    public function __toString()
    {
        return $this->year . str_pad($this->month, 2, "0", STR_PAD_LEFT);
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public static function current(): Month
    {
        $today = new \DateTime('today');
        return new Month($today->format('m'), $today->format('Y'));
    }

    public function previous(): Month
    {
        if ($this->month == 1) {
            return new Month(12, $this->year - 1);
        }
        return new Month($this->month - 1, $this->year);
    }

    public function next(): Month
    {
        if ($this->month == 12) {
            return new Month(1, $this->year + 1);
        }
        return new Month($this->month + 1, $this->year);
    }

    public function firstDay(): \DateTime
    {
        $date = new \DateTime();
        $date->setDate($this->year, $this->month, 1);
        return $date;
    }

    public function lastDay(): \DateTime
    {
        $day = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $date = new \DateTime();
        $date->setDate($this->year, $this->month, $day);
        return $date;
    }

}
