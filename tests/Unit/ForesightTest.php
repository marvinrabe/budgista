<?php

namespace Tests\Unit;

use App\AutoBudget\Foresight;
use App\Models\Transaction;
use Carbon\Carbon;
use RRule\RRule;
use Tests\TestCase;

class ForesightTest extends TestCase
{

    /** @test */
    public function split_future_nonrecurring_transactions_by_month() {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth();
        $transaction->amount = -12000;

        $transactions = collect([$transaction]);

        $foresight = new Foresight(Carbon::now()->firstOfMonth(), $transactions);

        $budget = $foresight->recommendedBudget();

        $this->assertEquals(6000, $budget);
    }

    /** @test */
    public function test_previously_saved_money_affects_value() {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth()->firstOfMonth();
        $transaction->amount = -30;

        $transactions = collect([$transaction]);

        $foresight = new Foresight(Carbon::now(), $transactions, 10);

        $budget = $foresight->recommendedBudget();

        $this->assertEquals(10, $budget);
    }

    /** @test */
    public function test_previously_saved_money_reduces_this_month_required() {
        $transaction = new Transaction();
        $transaction->date = Carbon::now();
        $transaction->amount = -120;

        $transactions = collect([$transaction]);

        $foresight = new Foresight(Carbon::now(), $transactions, 60);

        $budget = $foresight->recommendedBudget();

        $this->assertEquals(60, $budget);
    }

    /** @test */
    public function split_future_recurring_transactions_by_month() {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth(1);
        $transaction->rrule = new RRule([
            'FREQ' => 'MONTHLY',
            'INTERVAL' => 2
        ]);
        $transaction->amount = -20;

        $transactions = collect([$transaction]);

        $foresight = new Foresight(Carbon::now(), $transactions);

        $budget = $foresight->recommendedBudget();

        $this->assertEquals(10, $budget);
    }

}
