<?php

namespace App\AutoBudget;

use App\Models\Transaction;
use Carbon;
use Illuminate\Support\Collection;
use RRule\RRule;

class Foresight
{

    private $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function minimumMonthlyBudget() {
        $sum = 0;
        foreach($this->transactions as $transaction) {
            $sum += $this->calculateForTransaction($transaction);
        }
        return $sum;
    }

    private function calculateForTransaction(Transaction $transaction) {
        if($transaction->recurring) {
            return $this->calculateRecurringTransaction($transaction);
        }

        return $this->calculateNonrecurringTransaction($transaction);
    }

    private function calculateRecurringTransaction(Transaction $transaction) {
        /**
         * @var RRule $rrule
         */
        $rrule = $transaction->rrule;

        $lastPossibleDate = Carbon::now()->addYear(1)->lastOfMonth();

        $sum = 0;
        foreach ( $rrule as $occurrence ) {
            if($occurrence > $lastPossibleDate) {
                break;
            }
            $sum += $transaction->amount;
        }

        return $sum / 12;
    }

    private function calculateNonrecurringTransaction(Transaction $transaction)
    {
        $diffInMonths = Carbon::now()->diffInMonths($transaction->date);

        if($diffInMonths === 0) {
            return $transaction->amount;
        }

        return round($transaction->amount / ($diffInMonths+1));
    }

}