<?php


namespace Tests\Feature;


use App\Console\Commands\ProcessRecurringTransactions;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use RRule\RRule;
use Tests\TestCase;

class RecurringTransactionsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_recurs_transactions()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->cleared = true;
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->rrule = new RRule('FREQ=DAILY');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'amount' => $transaction->amount,
            'rrule' => 'FREQ=DAILY',
            'cleared' => false,
            'recurring' => 1,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }

    /** @test */
    public function it_assigns_id_to_recurred_transaction()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->rrule = new RRule('FREQ=DAILY;INTERVAL=1');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'family' => $transaction->id,
            'amount' => $transaction->amount,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }

    /** @test */
    public function it_assigns_family_to_recurred_transaction()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->family = uniqid();
        $transaction->rrule = new RRule('FREQ=DAILY');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'family' => $transaction->family,
            'amount' => $transaction->amount,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }

    /** @test */
    public function it_formats_the_recurrence()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->rrule = new RRule('FREQ=DAILY;INTERVAL=5');
        $transaction->save();

        $this->signIn($transaction->user)
            ->query('transaction')
            ->setArguments([
                'id' => $transaction->id
            ])
            ->setSelectionSet(['recurrence' => ['interval', 'frequency']])
            ->getData()
            ->assertJsonFragment([
                'recurrence' => [
                    'interval' => 5,
                    'frequency' => 'DAILY'
                ]
            ]);
    }

}
