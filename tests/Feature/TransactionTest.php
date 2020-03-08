<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase, WithFaker;

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
            ->assertRedirect("/accounts/{$account->id}");

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'amount' => 1234,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'payee' => 'Acme Co.'
        ]);
    }

    public function testUpdateNote()
    {
        $transaction = factory(Transaction::class)->create();
        $data = $transaction->getRawOriginal();
        $data['notes'] = $this->faker->text;

        $this
            ->signIn($transaction->user)
            ->put("/transactions/{$transaction->id}", $data)
            ->assertRedirect();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'notes' =>  $data['notes']
        ]);
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
