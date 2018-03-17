<?php

namespace App\Budget;

use App\Models\Transaction;
use Illuminate\Support\Collection;

class Foresight
{

    private $startAt;

    private $upcomingTransactions;

    private $previouslySavedMoney;

    public function __construct(Month $month, Collection $upcomingTransactions, $previouslySavedMoney = 0)
    {
        $this->startAt = $month->firstDay();
        $this->upcomingTransactions = $upcomingTransactions;
        $this->previouslySavedMoney = $previouslySavedMoney;
    }

    public function recommendedBudget()
    {
        $sum = 0;
        foreach ($this->upcomingTransactions as $transaction) {
            $sum += $this->calculateForTransaction($transaction);
        }
        return round(-1*$sum);
    }

    private function calculateForTransaction(Transaction $transaction)
    {
        $diffInMonths = $this->startAt->diffInMonths($transaction->date->lastOfMonth());

        if ($diffInMonths === 0) {
            return $transaction->amount + $this->split();
        }

        return ($transaction->amount + $this->split()) / ($diffInMonths + 1);
    }

    private function split()
    {
        if (count($this->upcomingTransactions) == 0) {
            return 0;
        }

        return $this->previouslySavedMoney / count($this->upcomingTransactions);
    }

}