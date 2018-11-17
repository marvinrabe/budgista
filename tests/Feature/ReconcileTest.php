<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReconcileTest extends TestCase
{

    use RefreshDatabase;

    protected $account;

    public function setUp()
    {
        parent::setUp();
        $this->account = factory(Account::class)->create();
    }

    public function reconcileBalance($data = [], $headers = [])
    {
        return $this
            ->signIn($this->account->user)
            ->post("/api/accounts/{$this->account->id}/reconcile", $data, $headers);
    }

    /** @test */
    public function it_can_only_be_done_by_the_account_owner()
    {
        $this
            ->signIn()
            ->post("/api/accounts/{$this->account->id}/reconcile", [
                'amount' => 12345
            ])
            ->assertStatus(403);
    }

    /** @test */
    public function it_requires_an_amount()
    {
        $this
            ->reconcileBalance([])
            ->assertSessionHasErrors([
                'amount'
            ]);
    }

    /** @test */
    public function it_should_fail_if_amount_is_not_an_integer()
    {
        $this
            ->reconcileBalance([
                'amount' => 'Hello World'
            ])
            ->assertSessionHasErrors([
                'amount'
            ]);
    }

    /** @test */
    public function it_sets_current_balance()
    {
        $this
            ->reconcileBalance([
                'amount' => 12345
            ])
            ->assertJson([
                'data' => [
                    'workingBalance' => 12345
                ]
            ]);
    }

    /** @test */
    public function it_has_a_localized_payee()
    {
        $this->account->user->update([
            'language' => 'de'
        ]);

        $this->reconcileBalance(['amount' => 12345], ['Accept-Language' => 'de']);

        $this->assertDatabaseHas('transactions', [
            'amount' => 12345,
            'payee' => 'Abstimmung'
        ]);
    }

    /** @test */
    public function it_should_clear_the_reconciliation_transaction()
    {
        $this->reconcileBalance(['amount' => 12345]);

        $this->assertDatabaseHas('transactions', [
            'amount' => 12345,
            'cleared' => true
        ]);
    }

    /** @test */
    public function it_marks_old_transactions_as_cleared()
    {
        $transaction = factory(Transaction::class)->create([
            'account_id' => $this->account->id
        ]);

        $this->reconcileBalance(['amount' => 12345]);

        $this->assertTrue($transaction->refresh()->cleared);
    }

}
