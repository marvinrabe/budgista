<?php

namespace App;

use App\Models\Category;
use Carbon\Carbon;

class Month
{

    protected $date;

    public function __construct($year, $month)
    {
        if ($month > 12 || $month < 1) {
            throw new \InvalidArgumentException('Value ' . $month . ' for month is invalid.');
        }
        if ($year < 1900 || $year >= 2100) {
            throw new \InvalidArgumentException('Value ' . $year . ' for year is invalid.');
        }

        $this->date = Carbon::createFromDate($year, $month, 1);
    }

    public static function current()
    {
        return self::fromString(Carbon::now()->format('Y-m'));
    }

    public static function fromString($string)
    {
        list($year, $month) = explode('-', $string, 2);

        return new self($year, $month);
    }

    public function __toString()
    {
        return $this->date->format('Y-m');
    }

    public function getMonth()
    {
        return $this->date->month;
    }

    public function getYear()
    {
        return $this->date->year;
    }

    public function previous()
    {
        $previousMonth = (clone $this->date)->subMonth();
        return new self($previousMonth->year, $previousMonth->month);
    }

    public function next()
    {
        $nextMonth = (clone $this->date)->addMonth();
        return new self($nextMonth->year, $nextMonth->month);
    }

    /**
     * @return Carbon
     */
    public function firstDay()
    {
        return (clone $this->date)->firstOfMonth();
    }

    /**
     * @return Carbon
     */
    public function lastDay()
    {
        return (clone $this->date)->lastOfMonth();
    }

}