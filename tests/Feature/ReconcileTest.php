<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ReconcileTest extends TestCase
{

    use RefreshDatabase;

    public function testReconcileOnlyOwnAccounts()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn()
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 12345
            ])
            ->assertStatus(404);
    }

    public function testRequiresAmount()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [])
            ->assertSessionHasErrors([
                'amount'
            ]);
    }

    public function testRequiresInteger()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 'Hello World'
            ])
            ->assertSessionHasErrors([
                'amount'
            ]);
    }

    public function testUpdatesBalance()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 12345
            ]);

        $this->assertEquals(12345, $account->balance);
    }

    public function testLocalizePayee()
    {
        App::setLocale('de');

        $this->withoutMiddleware(DetectLocale::class);

        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 12345
            ]);

        $this->assertDatabaseHas('transactions', [
            'amount' => 12345,
            'payee' => 'Abstimmung'
        ]);
    }

    public function testClearReconciliationTransaction()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 12345
            ]);

        $this->assertDatabaseHas('transactions', [
            'amount' => 12345,
            'cleared' => true
        ]);
    }

    public function testMarkTransactionsCleared()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->create([
            'account_id' => $account->id,
            'user_id' => $account->user_id
        ]);

        $this
            ->signIn($account->user)
            ->post("/accounts/{$account->id}/reconcile", [
                'amount' => 12345
            ]);

        $this->assertTrue($transaction->refresh()->cleared);
    }

}
