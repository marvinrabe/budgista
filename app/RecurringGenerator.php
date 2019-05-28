<?php

namespace App;

use App\Models\Transaction;
use Carbon\Carbon;

class RecurringGenerator
{

    public function generateOccurrences(Transaction $transaction)
    {
        $occurrences = $this->getPendingOccurrences($transaction);
        if (count($occurrences) == 0) {
            return [$transaction];
        }

        /**
         * @var RRule $rrule
         */
        $rrule = $transaction->rrule;

        $transaction->rrule = null;

        $results = collect($occurrences)
            ->map(function ($date) use ($transaction) {
                $newTransaction = $transaction->replicate(['id', 'date', 'cleared']);
                $newTransaction->date = $date;
                $newTransaction->family = $transaction->family ?? $transaction->id;
                $newTransaction->cleared = false;
                return $newTransaction;
            })
            ->prepend($transaction);

        $last = $results->pop();
        $last->rrule = $rrule;

        return $results->push($last);
    }

    public function getPendingOccurrences(Transaction $transaction)
    {
        if (!$transaction->recurring) {
            return [];
        }

        /**
         * @var RRule $rrule
         */
        $rrule = $transaction->rrule;

        $previous = $rrule->getOccurrencesBetween($transaction->date->endofDay(), Carbon::now()->endofDay());
        $next = $rrule->getOccurrencesBetween(Carbon::now()->addDay()->startOfDay(), null, 1);

        return array_merge($previous, $next);
    }

}
