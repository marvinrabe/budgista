<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use GraphQL\RawObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function it_creates_accounts()
    {
        $this->mutation('accountCreate')
            ->setArguments([
                'initialBalance' => 0,
                'input' => new RawObject('{name: "New Account", icon: "wallet", isTracking: true}')
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
        $this->mutation('accountCreate')
            ->setArguments([
                'initialBalance' => 1234,
                'input' => new RawObject('{name: "New Account", icon: "wallet", isTracking: true}')
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
        $this->post("/api/accounts", [])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_should_update_accounts()
    {
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $this->mutation('accountUpdate')
            ->setArguments([
                'id' => $account->id,
                'input' => new RawObject('{name: "New Name", icon: "wallet", isTracking: true}')
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

        $this->mutation('accountUpdate')
            ->setArguments([
                'id' => $otherAccount->id,
                'input' => new RawObject('{name: "New Name", icon: "wallet", isTracking: true}')
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
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $response = $this->getJson('/api/accounts/'.$account->id);

        $this->get($response->json()['links']['transactions'])
            ->assertSuccessful();
    }

    /** @test */
    public function it_lists_accounts()
    {
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $this->query('accounts')
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'id' => $account->id,
                'name' => $account->name
            ]);
    }

    /** @test */
    public function it_only_lists_accounts_of_current_user()
    {
        $account = factory(Account::class)->create();

        $this->query('accounts')
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonMissing([
                'id' => $account->id
            ]);
    }

    /** @test */
    public function it_returns_account_balance()
    {
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);
        $transaction = factory(Transaction::class)->create([
            'account_id' => $account->id
        ]);

        $this->query('accounts')
            ->setSelectionSet(['id', 'balance'])
            ->getData()
            ->assertJsonFragment([
                'id' => $account->id,
                'balance' => $transaction->amount
            ]);
    }

}
