<?php

namespace Tests\Unit;

use App\Forecast;
use App\Month;
use App\Transaction;
use Carbon\Carbon;
use RRule\RRule;
use Tests\TestCase;

class ForesightTest extends TestCase
{

    /** @test */
    public function split_future_nonrecurring_transactions_by_month()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth();
        $transaction->amount = -12000;

        $transactions = collect([$transaction]);

        $foresight = new Forecast(Month::current(), $transactions);

        $this->assertEquals(6000, $foresight->recommendedBudget());
    }

    /** @test */
    public function previously_saved_money_affects_recommended_budget()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth()->firstOfMonth();
        $transaction->amount = -30;

        $transactions = collect([$transaction]);

        $foresight = new Forecast(Month::current(), $transactions, 10);

        $this->assertEquals(10, $foresight->recommendedBudget());
    }

    /** @test */
    public function previously_saved_money_reduces_this_month_required()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now();
        $transaction->amount = -120;

        $transactions = collect([$transaction]);

        $foresight = new Forecast(Month::current(), $transactions, 60);

        $this->assertEquals(60, $foresight->recommendedBudget());
    }

    /** @test */
    public function split_future_recurring_transactions_by_month()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth(1);
        $transaction->rrule = new RRule([
            'FREQ' => 'MONTHLY',
            'INTERVAL' => 2
        ]);
        $transaction->amount = -20;

        $transactions = collect([$transaction]);

        $foresight = new Forecast(Month::current(), $transactions);

        $this->assertEquals(10, $foresight->recommendedBudget());
    }

    /** @test */
    public function already_occured_recurring_transaction_wont_be_covered()
    {
        $transaction1 = new Transaction();
        $transaction1->date = Carbon::now();
        $transaction1->amount = -20;
        $transaction1->family = 'test';

        $transaction2 = new Transaction();
        $transaction2->date = Carbon::now()->addMonth();
        $transaction2->rrule = new RRule([
            'FREQ' => 'MONTHLY',
            'INTERVAL' => 1
        ]);
        $transaction2->amount = -20;
        $transaction2->family = 'test';

        $transactions = collect([$transaction1, $transaction2]);

        $foresight = new Forecast(Month::current(), $transactions);

        $this->assertEquals(20, $foresight->recommendedBudget());
    }

}
