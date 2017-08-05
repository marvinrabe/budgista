<?php

namespace AppBundle\Budget;

use AppBundle\Entity\Money;
use AppBundle\Entity\Month;

class Budget implements \Iterator
{

    protected $month;
    protected $previousMonthAvailable;
    protected $funds;

    /**
     * @var BudgetRow[]
     */
    protected $rows = [];

    protected $index = 0;


    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function add(BudgetRow $row): void
    {
        $this->rows[] = $row;
    }

    /**
     * Return the current element
     * @return BudgetRow
     */
    public function current()
    {
        return $this->rows[$this->index];
    }

    /**
     * Move forward to next element
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @return int
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->rows[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->index = 0;
    }

    public function getPreviousMonthAvailable(): Money
    {
        return $this->previousMonthAvailable;
    }

    public function setPreviousMonthAvailable(Money $previousMonthAvailable): void
    {
        $this->previousMonthAvailable = $previousMonthAvailable;
    }

    public function getFunds(): Money
    {
        return $this->funds;
    }

    public function setFunds(Money $funds): void
    {
        $this->funds = $funds;
    }

    public function getBudgeted(): Money
    {
        $sum = new Money(0);
        foreach ($this->rows as $row) {
            $sum = Money::sum($row->getBudgeted(), $sum);
        }
        return new Money(-1 * $sum->getAmount());
    }

    public function getAvailable(): Money
    {
        return Money::sum($this->getPreviousMonthAvailable(), $this->getFunds(), $this->getBudgeted());
    }

}
