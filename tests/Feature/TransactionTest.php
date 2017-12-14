<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_saves_a_transaction_successfully()
    {
        $transaction = factory(Transaction::class)->make();

        $this
            ->signIn($transaction->account->user)
            ->post('/api/transactions', $transaction->toArray())
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_only_create_transactions_in_own_category()
    {
        $transaction = factory(Transaction::class)->make();

        $data = $transaction->toArray();
        $data['category_id'] = factory(Category::class)->create()->id;

        $this
            ->signIn($transaction->account->user)
            ->post('/api/transactions', $data)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_can_only_update_transactions_with_own_category()
    {
        $transaction = factory(Transaction::class)->create();

        $data = $transaction->toArray();
        $data['category_id'] = factory(Category::class)->create()->id;

        $this
            ->signIn($transaction->account->user)
            ->put("/api/transactions/{$transaction->id}", $data)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_can_only_create_transactions_in_own_account()
    {
        $transaction = factory(Transaction::class)->make();

        $data = $transaction->toArray();
        $data['account_id'] = factory(Account::class)->create()->id;

        $this
            ->signIn()
            ->post('/api/transactions', $data)
            ->assertSessionHasErrors('account_id');
    }

}