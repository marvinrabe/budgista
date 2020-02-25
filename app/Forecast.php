<?php

namespace App;

use App\Transaction;
use App\Month;
use Illuminate\Support\Collection;

class Forecast
{

    private $month;

    private $upcomingTransactions;

    private $previouslySavedMoney;

    private $families;

    public function __construct(Month $month, Collection $upcomingTransactions, $previouslySavedMoney = 0)
    {
        $this->month = $month;
        $this->upcomingTransactions = $upcomingTransactions;
        $this->previouslySavedMoney = $previouslySavedMoney;
        $this->families = collect($upcomingTransactions)
            ->flatMap(function (Transaction $transaction) use ($month) {
                if ($transaction->date > $month->lastDay()) {
                    return [];
                }
                $result = [$transaction->id];
                if ($transaction->family) {
                    $result[] = $transaction->family;
                }
                return $result;
            })
            ->values()
            ->toArray();
    }

    public function recommendedBudget()
    {
        $sum = 0;
        foreach ($this->upcomingTransactions as $transaction) {
            $sum += $this->calculateForTransaction($transaction);
        }
        return round(-1 * $sum);
    }

    private function calculateForTransaction(Transaction $transaction)
    {
        if ($transaction->date > $this->month->lastDay() && in_array($transaction->family, $this->families)) {
            return 0;
        }

        $diffInMonths = $this->month->firstDay()->diffInMonths($transaction->date->lastOfMonth());

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
