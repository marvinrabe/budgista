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
        $transaction->date = Carbon::now()->addMonth(2);
        $transaction->amount = 30;

        $transactions = collect([$transaction]);

        $foresight = new Foresight($transactions);

        $budget = $foresight->minimumMonthlyBudget();

        $this->assertEquals(10, $budget);
    }

    /** @test */
    public function split_future_recurring_transactions_by_month() {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->addMonth(1);
        $transaction->rrule = new RRule([
            'FREQ' => 'MONTHLY',
            'INTERVAL' => 2
        ]);
        $transaction->amount = 20;

        $transactions = collect([$transaction]);

        $foresight = new Foresight($transactions);

        $budget = $foresight->minimumMonthlyBudget();

        $this->assertEquals(10, $budget);
    }

}
