<?php

namespace App\AutoBudget;

use App\Models\Transaction;
use Carbon;
use Illuminate\Support\Collection;
use RRule\RRule;

class Foresight
{

    private $upcomingTransactions;

    private $previouslySavedMoney;

    public function __construct(Collection $upcomingTransactions, $previouslySavedMoney = 0)
    {
        $this->upcomingTransactions = $upcomingTransactions;
        $this->previouslySavedMoney = $previouslySavedMoney;
    }

    public function split()
    {
        if (count($this->upcomingTransactions) == 0) {
            return 0;
        }

        return $this->previouslySavedMoney / count($this->upcomingTransactions);
    }

    public function minimumMonthlyBudget()
    {
        $sum = 0;
        foreach ($this->upcomingTransactions as $transaction) {
            $sum += $this->calculateForTransaction($transaction);
        }
        return $sum >= 0? $sum : 0;
    }

    private function calculateForTransaction(Transaction $transaction)
    {
        if ($transaction->recurring) {
            return $this->calculateRecurringTransaction($transaction);
        }

        return $this->calculateNonrecurringTransaction($transaction);
    }

    private function calculateRecurringTransaction(Transaction $transaction)
    {
        /**
         * @var RRule $rrule
         */
        $rrule = $transaction->rrule;

        $lastPossibleDate = Carbon::now()->addYear(1)->lastOfMonth();

        $sum = 0;
        foreach ($rrule as $occurrence) {
            if ($occurrence > $lastPossibleDate) {
                break;
            }
            $sum += $transaction->amount;
        }

        return round(($sum - $this->split()) / 12);
    }

    private function calculateNonrecurringTransaction(Transaction $transaction)
    {
        $diffInMonths = Carbon::now()->diffInMonths($transaction->date->lastOfMonth());

        if ($diffInMonths === 0) {
            return $transaction->amount - $this->split();
        }

        return round(($transaction->amount - $this->split()) / ($diffInMonths + 1));
    }

}