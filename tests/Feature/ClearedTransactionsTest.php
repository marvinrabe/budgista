<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearedTransactionsTest extends TestCase
{

    use RefreshDatabase;

    public function testClearTransaction()
    {
        $transaction = factory(Transaction::class)->state('uncleared')->create();

        $this->assertFalse($transaction->cleared);

        $this
            ->signIn($transaction->user)
            ->from("/accounts/{$transaction->account_id}")
            ->post('/clearedTransactions', [
                'id' => $transaction->id
            ])
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertTrue($transaction->fresh()->cleared);
    }

    public function testUnclearTransaction()
    {
        $transaction = factory(Transaction::class)->state('cleared')->create();

        $this->assertTrue($transaction->cleared);

        $this
            ->signIn($transaction->user)
            ->from("/accounts/{$transaction->account_id}")
            ->delete("/clearedTransactions/{$transaction->id}")
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertFalse($transaction->fresh()->cleared);
    }

    public function testCanNotClearOtherUsersTransactions()
    {
        $transaction = factory(Transaction::class)->state('uncleared')->create();

        $this->assertFalse($transaction->cleared);

        $this
            ->signIn()
            ->post('/clearedTransactions', [
                'id' => $transaction->id
            ])
            ->assertSessionHasErrors('id');

        $this->assertFalse($transaction->refresh()->cleared);
    }

    public function testCanNotUnclearOtherUsersTransactions()
    {
        $transaction = factory(Transaction::class)->state('cleared')->create();

        $this->assertTrue($transaction->cleared);

        $this
            ->signIn()
            ->from("/accounts/{$transaction->account_id}")
            ->delete("/clearedTransactions/{$transaction->id}")
            ->assertNotFound();

        $this->assertTrue($transaction->fresh()->cleared);
    }

}
