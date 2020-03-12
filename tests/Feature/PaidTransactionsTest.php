<?php

namespace Tests\Feature;

use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaidTransactionsTest extends TestCase
{

    use RefreshDatabase;

    public function testClearTransaction()
    {
        $transaction = factory(Transaction::class)->state('unpaid')->create();

        $this->assertFalse($transaction->paid);

        $this
            ->signIn($transaction->user)
            ->from("/accounts/{$transaction->account_id}")
            ->post('/paidTransactions', [
                'id' => $transaction->id
            ])
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertTrue($transaction->fresh()->paid);
    }

    public function testUnclearTransaction()
    {
        $transaction = factory(Transaction::class)->state('paid')->create();

        $this->assertTrue($transaction->paid);

        $this
            ->signIn($transaction->user)
            ->from("/accounts/{$transaction->account_id}")
            ->delete("/paidTransactions/{$transaction->id}")
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertFalse($transaction->fresh()->paid);
    }

    public function testCanNotClearOtherUsersTransactions()
    {
        $transaction = factory(Transaction::class)->state('unpaid')->create();

        $this->assertFalse($transaction->paid);

        $this
            ->signIn()
            ->post('/paidTransactions', [
                'id' => $transaction->id
            ])
            ->assertSessionHasErrors('id');

        $this->assertFalse($transaction->refresh()->paid);
    }

    public function testCanNotUnclearOtherUsersTransactions()
    {
        $transaction = factory(Transaction::class)->state('paid')->create();

        $this->assertTrue($transaction->paid);

        $this
            ->signIn()
            ->from("/accounts/{$transaction->account_id}")
            ->delete("/paidTransactions/{$transaction->id}")
            ->assertNotFound();

        $this->assertTrue($transaction->fresh()->paid);
    }

}
