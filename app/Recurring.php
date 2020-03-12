<?php

namespace App;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use RRule\RRule;

class Recurring extends RRule implements Arrayable
{
    public static function fromString($string)
    {
        return new static($string);
    }

    public static function fromRequest($request)
    {
        return new static([
            'FREQ' => $request['frequency'],
            'INTERVAL' => $request['interval']
        ]);
    }

    public function toArray()
    {
        return [
            'frequency' => $this->frequency(),
            'interval' => $this->interval()
        ];
    }

    public function interval()
    {
        return $this->interval ?? 1;
    }

    public function frequency()
    {
        $frequencies = array_flip(static::$frequencies);

        if (!$this->freq || !isset($frequencies[$this->freq])) {
            return 'MONTHLY';
        }

        return $frequencies[$this->freq];
    }

    public function generateOccurrences(Transaction $transaction)
    {
        $occurrences = $this->getPendingOccurrences($transaction);

        if (count($occurrences) == 0) {
            return Collection::make();
        }

        return Collection::make($occurrences)
            ->map(function ($date) use ($transaction) {
                $newTransaction = $transaction->replicate(['id', 'date', 'paid', 'related_id']);
                $newTransaction->date = $date;
                $newTransaction->paid = false;
                return $newTransaction;
            });
    }

    public function getPendingOccurrences(Transaction $transaction)
    {
        $this->dtstart = $transaction->date;

        $previous = $this->getOccurrencesBetween($transaction->date->endofDay(), Carbon::now()->endofDay());
        $next = $this->getOccurrencesBetween(Carbon::now()->addDay()->startOfDay(), null, 1);

        return array_merge($previous, $next);
    }
}
