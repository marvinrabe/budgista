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

    public function __construct(int $year, int $month)
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
        return $this->year . '-' . str_pad($this->month, 2, "0", STR_PAD_LEFT);
    }

    public static function fromString(string $string): Month
    {
        $year = substr($string, 0, 4);
        $month = substr($string, -2);
        return new Month($year, $month);
    }

    public static function current(): Month
    {
        $today = new \DateTime('now');
        return new Month($today->format('Y'), $today->format('m'));
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function previous(): Month
    {
        if ($this->month == 1) {
            return new Month($this->year - 1, 12);
        }
        return new Month($this->year, $this->month - 1);
    }

    public function next(): Month
    {
        if ($this->month == 12) {
            return new Month($this->year + 1, 1);
        }
        return new Month($this->year, $this->month + 1);
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
