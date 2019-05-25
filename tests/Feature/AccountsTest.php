<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_accounts()
    {
        $this->signIn()
            ->mutation('accountCreate')
            ->setArguments([
                'input' => [
                    'name' => 'New Account',
                    'icon' => 'wallet',
                    'isTracking' => true
                ]
            ])
            ->setSelectionSet([
                'name', 'icon', 'isTracking'
            ])
            ->getData()
            ->assertJson([
                'data' => [
                    'accountCreate' => [
                        'name' => "New Account",
                        'icon' => "wallet",
                        'isTracking' => true
                    ]
                ]
            ]);

        $this->assertDatabaseHas('accounts', [
            'name' => 'New Account',
            'icon' => 'wallet',
            'tracking' => true,
            'user_id' => Auth()->id()
        ]);
    }

    /** @test */
    public function it_initialises_account_balance()
    {
        $this->signIn()
            ->mutation('accountCreate')
            ->setArguments([
                'initialBalance' => 1234,
                'input' => [
                    'name' => 'New Account',
                    'icon' => 'wallet',
                    'isTracking' => true
                ]
            ])
            ->setSelectionSet([
                'balance', 'balanceCleared'
            ])
            ->getData()
            ->assertJson([
                'data' => [
                    'accountCreate' => [
                        'balance' => 1234,
                        'balanceCleared' => 1234
                    ]
                ]
            ]);
    }

    /** @test */
    public function accounts_should_have_a_name()
    {
        $this->signIn()
            ->post("/api/accounts", [])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_should_update_accounts()
    {
        $account = factory(Account::class)->create();

        $this->signIn($account->user)
            ->mutation('accountUpdate')
            ->setArguments([
                'id' => $account->id,
                'input' => [
                    'name' => 'New Name',
                    'icon' => 'wallet',
                    'isTracking' => true
                ]
            ])
            ->setSelectionSet([
                'id', 'name', 'icon', 'isTracking'
            ])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'accountUpdate' => [
                        'id' => $account->id,
                        'name' => 'New Name',
                        'icon' => 'wallet',
                        'isTracking' => true
                    ]
                ]
            ]);

        $account = $account->fresh();

        $this->assertEquals('New Name', $account->name);
        $this->assertEquals('wallet', $account->icon);
        $this->assertTrue($account->tracking);
    }

    /** @test */
    public function it_can_not_update_other_user_accounts()
    {
        $otherAccount = factory(Account::class)->create();

        $nameBefore = $otherAccount->name;

        $this->signIn()
            ->mutation('accountUpdate')
            ->setArguments([
                'id' => $otherAccount->id,
                'input' => ['name' => "New Name", 'icon' => 'wallet', 'isTracking' => true]
            ])
            ->setSelectionSet([
                'id'
            ])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'accountUpdate' => null
                ]
            ]);

        $this->assertEquals($nameBefore, $otherAccount->fresh()->name);
    }

    /** @test */
    public function accounts_have_transaction_links()
    {
        $account = factory(Account::class)->create();

        $this->signIn($account->user);

        $response = $this->getJson('/api/accounts/'.$account->id);

        $this->get($response->json()['links']['transactions'])
            ->assertSuccessful();
    }

    /** @test */
    public function it_lists_accounts()
    {
        $account = factory(Account::class)->create();

        $this->signIn($account->user);

        $this->query('accounts', ['id', 'name'])
            ->assertJsonFragment([
                'id' => $account->id,
                'name' => $account->name
            ]);
    }

    /** @test */
    public function it_does_not_list_accounts_of_other_users()
    {
        $account = factory(Account::class)->create();

        $this->signIn()
            ->query('accounts', ['id'])
            ->assertJsonMissing([
                'id' => $account->id
            ]);
    }

    /** @test */
    public function it_returns_account_balance()
    {
        $transaction = factory(Transaction::class)->create();

        $this->signIn($transaction->user)
            ->query('accounts', ['id', 'balance'])
            ->assertJsonFragment([
                'id' => $transaction->account_id,
                'balance' => $transaction->amount
            ]);
    }

    /** @test */
    public function it_deletes_account()
    {
        $account = factory(Account::class)->create();

        $this->signIn($account->user)
            ->mutation(
                'accountDelete',
                ['id' => $account->id],
                ['id']
            )
            ->assertJsonFragment([
                'data' => [
                    'accountDelete' => [
                        'id' => $account->id
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id
        ]);
    }


    /** @test */
    public function it_does_not_delete_other_users_account()
    {
        $otherAccount = factory(Account::class)->create();

        $this->signIn()
            ->mutation(
                'accountDelete',
                ['id' => $otherAccount->id],
                ['id']
            )
            ->assertJsonFragment([
                'data' => [
                    'accountDelete' => null
                ]
            ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $otherAccount->id
        ]);
    }

}
