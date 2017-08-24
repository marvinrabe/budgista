<?php

namespace App;

use Propaganistas\LaravelIntl\Facades\Carbon;

class Month
{

    /**
     * @var int
     */
    protected $month;

    /**
     * @var int
     */
    protected $year;

    public function __construct($year, $month)
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

    public static function fromString($string)
    {
        $year = substr($string, 0, 4);
        $month = substr($string, -2);
        return new Month($year, $month);
    }

    public function forHumans()
    {
        return $this->firstDay()->format('M. Y');
    }

    public static function current()
    {
        $today = new \DateTime('now');
        return new Month($today->format('Y'), $today->format('m'));
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function previous()
    {
        if ($this->month == 1) {
            return new Month($this->year - 1, 12);
        }
        return new Month($this->year, $this->month - 1);
    }

    public function next()
    {
        if ($this->month == 12) {
            return new Month($this->year + 1, 1);
        }
        return new Month($this->year, $this->month + 1);
    }

    public function firstDay()
    {
        return Carbon::createFromDate($this->year, $this->month, 1);
    }

    public function lastDay()
    {
        $day = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        return Carbon::createFromDate($this->year, $this->month, $day);
    }
}