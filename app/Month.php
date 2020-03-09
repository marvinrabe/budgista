<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

class Month implements Arrayable
{

    protected $date;

    public function __construct($year, $month)
    {
        if ($month > 12 || $month < 1) {
            throw new \InvalidArgumentException("Value $month for month is invalid.");
        }
        if ($year < 1900 || $year >= 2100) {
            throw new \InvalidArgumentException("Value $year for year is invalid.");
        }

        $this->date = Carbon::createFromDate($year, $month, 1);
    }

    public static function range(Month $start, Month $end): iterable
    {
        if ((string) $start > (string) $end) {
            throw new \InvalidArgumentException("Range is invalid.");
        }

        $result = Collection::make();
        for ($pointer = $start; (string) $pointer <= (string) $end; $pointer = $pointer->next()) {
            $result->push($pointer);
        }
        return $result;
    }

    public static function current()
    {
        return self::fromString(Carbon::now()->format('Y-m'));
    }

    public static function fromString($string)
    {
        if (empty($string)) {
            return Month::current();
        }

        list($year, $month) = explode('-', $string, 2);

        return new self($year, $month);
    }

    public function __toString()
    {
        return $this->value();
    }

    public function value()
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

    public function toArray()
    {
        return [
            'value' => $this->value()
        ];
    }
}
