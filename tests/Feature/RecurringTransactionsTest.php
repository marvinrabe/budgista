<?php


namespace Tests\Feature;


use App\Console\Commands\ProcessRecurringTransactions;
use App\Account;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;
use RRule\RRule;
use Tests\TestCase;

class RecurringTransactionsTest extends TestCase
{

    use RefreshDatabase;

    public function testRecursTransactions()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->cleared = true;
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->recurring = true;
        $transaction->rrule = (string) new RRule('FREQ=DAILY');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'amount' => $transaction->amount,
            'cleared' => false,
            'recurring' => 1,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }

    public function testAddFamilyId()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->recurring = true;
        $transaction->rrule = (string) new RRule('FREQ=DAILY;INTERVAL=1');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'family' => $transaction->id,
            'amount' => $transaction->amount,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }

    public function testKeepsFamilyId()
    {
        $transaction = factory(Transaction::class)->make();
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->family = Uuid::uuid4();
        $transaction->recurring = true;
        $transaction->rrule = (string) new RRule('FREQ=DAILY');
        $transaction->save();

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertDatabaseHas('transactions', [
            'family' => $transaction->family,
            'amount' => $transaction->amount,
            'date' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
    }
}
