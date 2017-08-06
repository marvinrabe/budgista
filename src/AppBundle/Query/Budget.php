<?php

namespace AppBundle\Query;

use AppBundle\Entity\Money;
use AppBundle\Entity\Month;

class Budget
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

    public function addRow(BudgetRow $row): void
    {
        $this->rows[] = $row;
    }

    public function getRows()
    {
        return $this->rows;
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
