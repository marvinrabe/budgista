<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase;

    public function testPreselectAccount()
    {
        $account = factory(Account::class)->create();

        $response = $this
            ->signIn($account->user)
            ->get("/transactions/create?account={$account->id}");

        $response->assertHasProp('account');
        $this->assertEquals($account->id, $response->props()['account']['id']);
    }

    public function testStoreTransaction()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id
        ]);

        $this
            ->withoutExceptionHandling()
            ->signIn($account->user)
            ->post('/transactions', $transaction)
            ->assertRedirect("/accounts/{$account->id}");

        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'payee' => $transaction['payee'],
            'amount' => $transaction['amount'],
            'date' => $transaction['date'],
        ]);
    }

    public function testUpdateTransaction()
    {
        $transaction = factory(Transaction::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $transaction->user_id
        ]);
        $category = factory(Category::class)->create([
            'user_id' => $transaction->user_id
        ]);

        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", [
                'date' => Carbon::now()->format('Y-m-d'),
                'amount' => 1234,
                'payee' => 'Acme Co.',
                'account_id' => $account->id,
                'category_id' => $category->id
            ])
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'amount' => 1234,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'payee' => 'Acme Co.'
        ]);
    }

    public function testCantCreateWithOtherUsersCategory()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id,
            'category_id' => factory(Category::class)->create()->id,
        ]);

        $this
            ->signIn($account->user)
            ->post('/transactions', $transaction)
            ->assertSessionHasErrors('category_id');
    }

    public function testCantCreateWithOtherUsersAccount()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id,
        ]);

        $this
            ->signIn()
            ->post('/transactions', $transaction)
            ->assertSessionHasErrors('account_id');
    }

    public function testCantUpdateToOtherUsersCategory()
    {
        $category = factory(Category::class)->create();

        $transaction = factory(Transaction::class)->create();

        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", [
                'category_id' => $category->id
            ])
            ->assertSessionHasErrors('category_id');
    }

    public function testCantUpdateToOtherUsersAccount()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->create();

        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", [
                'account_id' => $account->id
            ])
            ->assertSessionHasErrors('account_id');
    }


    public function testDeleteTransaction()
    {
        $transaction = factory(Transaction::class)->create();;

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id
        ]);

        $this->signIn($transaction->user)
            ->delete("/transactions/{$transaction->id}")
            ->assertRedirect("/accounts/{$transaction->account_id}");

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id
        ]);
    }

    public function testCanNotDeleteOtherUsersTransaction()
    {
        $transaction = factory(Transaction::class)->create();

        $this->signIn()
            ->delete("/transactions/{$transaction->id}")
            ->assertNotFound();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id
        ]);
    }

}
