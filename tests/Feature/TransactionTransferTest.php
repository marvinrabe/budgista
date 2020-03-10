<?php

namespace Tests\Feature;

use App\Account;
use App\Console\Commands\ProcessRecurringTransactions;
use App\Transaction;
use App\ViewModels\TransactionForm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTransferTest extends TestCase
{
    use RefreshDatabase;

    public function testTransferMoneyBetweenAccounts()
    {
        $accountA = factory(Account::class)->create();
        $accountB = factory(Account::class)->create([
            'user_id' => $accountA->user_id
        ]);

        $this
            ->signIn($accountA->user)
            ->withoutExceptionHandling()
            ->post('/transactions', [
                'account_id' => $accountA->id,
                'category_id' => 'account:'.$accountB->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'amount' => 100
            ])
            ->assertRedirect("/accounts/{$accountA->id}");

        $this->assertDatabaseHas('transactions', [
            'account_id' => $accountA->id,
            'amount' => 100
        ]);

        $this->assertDatabaseHas('transactions', [
            'account_id' => $accountB->id,
            'amount' => -100
        ]);
    }

    public function testUpdateTransfers()
    {
        $transaction = factory(Transaction::class)->state('transfer')->create();
        $old_related_id = $transaction->related_id;

        $date = Carbon::now()->format('Y-m-d');
        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", [
                'account_id' => $transaction->account_id,
                'category_id' => 'account:'.$transaction->related->account_id,
                'payee' => $transaction->payee,
                'notes' => 'This is a test.',
                'date' => $date,
                'amount' => 100
            ])
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $transaction->refresh();

        $this->assertEquals(100, $transaction->amount);
        $this->assertEquals('This is a test.', $transaction->notes);
        $this->assertEquals(-100, $transaction->related->amount);
        $this->assertEquals('This is a test.', $transaction->related->notes);

        $this->assertDatabaseMissing('transactions', [
            'id' => $old_related_id
        ]);
    }

    public function testKeepStateOnUpdate()
    {
        $transaction = factory(Transaction::class)->state('transfer')->create();
        $transaction->related->update(['cleared' => true]);
        $this->assertTrue($transaction->related->cleared);

        $date = Carbon::now()->format('Y-m-d');
        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", [
                'account_id' => $transaction->account_id,
                'category_id' => 'account:'.$transaction->related->account_id,
                'payee' => $transaction->payee,
                'notes' => 'This is a test.',
                'date' => $date,
                'amount' => 100
            ])
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertTrue($transaction->fresh()->related->cleared);
    }

    public function testDeletesRelatedTransaction()
    {
        $transaction = factory(Transaction::class)->state('transfer')->create();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id
        ]);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->related_id
        ]);

        $this->signIn($transaction->user)
            ->delete("/transactions/{$transaction->id}")
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id
        ]);
        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->related_id
        ]);
    }

    public function testReturnsAccountOfRelated()
    {
        $transaction = factory(Transaction::class)->state('transfer')->create();

        $view = new TransactionForm($transaction);
        $transactionData = $view->transaction();

        $this->assertEquals('account:'.$transaction->related->account_id, $transactionData['category_id']);
    }

    public function testRecursTransactions()
    {
        $transaction = factory(Transaction::class)->state('transfer')->create([
            'rrule' => 'FREQ=DAILY',
            'recurring' => true,
            'date' => Carbon::now(),
            'amount' => 12300 // Only positive amounts are recurred properly
        ]);

        $this->signIn($transaction->user);

        $this->assertEquals(0,  Transaction::sum('amount'));
        $this->assertEquals(2,  Transaction::count());

        $this->artisan(ProcessRecurringTransactions::class);

        $this->assertEquals(0,  Transaction::sum('amount'));
        $this->assertEquals(4,  Transaction::count());

        // Recurred Transactions relate to each other not to parent.
        $this->assertEquals(1,  Transaction::where('related_id', $transaction->id)->count());
    }
}
