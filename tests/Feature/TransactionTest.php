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
    public function it_cant_create_transactions_in_someone_elses_category()
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
    public function it_cant_update_transactions_to_someone_elses_category()
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
    public function it_cant_create_transactions_in_someone_elses_account()
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