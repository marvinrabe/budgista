<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionCreateTest extends TestCase
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

    public function testPreselectCategory()
    {
        $category = factory(Category::class)->create();

        $response = $this
            ->signIn($category->user)
            ->get("/transactions/create?category={$category->id}");

        $response->assertHasProp('category');
        $this->assertEquals($category->id, $response->props()['category']['id']);
    }

    public function testSetReferer()
    {
        $account = factory(Account::class)->create();

        $response = $this
            ->signIn($account->user)
            ->get("/transactions/create?referer=%2Fbudget");

        $response->assertHasProp('referer');
        $this->assertEquals('/budget', $response->props()['referer']);
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

    public function testRedirectToReferer()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id
        ]);

        $transaction['referer'] = '/budget';

        $this
            ->signIn($account->user)
            ->post('/transactions', $transaction)
            ->assertRedirect('/budget');
    }

    public function testDontRedirectToExternalSites()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id
        ]);

        $transaction['referer'] = 'http://www.example.com/';

        $this
            ->signIn($account->user)
            ->post('/transactions', $transaction)
            ->assertRedirect("/accounts/{$account->id}");
    }

    public function testDontRedirectToInvalidPath()
    {
        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id
        ]);

        $transaction['referer'] = '/this/is/a/invalid/path';

        $this
            ->signIn($account->user)
            ->post('/transactions', $transaction)
            ->assertRedirect("/accounts/{$account->id}");
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

}
