<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function it_should_save_accounts()
    {
        $account = factory(Account::class)->raw();

        $this->post("/api/accounts", $account)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $account['name']
                ]
            ]);

        $this->assertDatabaseHas('accounts', [
            'name' => $account['name'],
            'user_id' => Auth()->id()
        ]);
    }

    /** @test */
    public function it_initialises_account_balance()
    {
        $this
            ->post("/api/accounts", [
                'name' => 'Test Account',
                'initial_balance' => 1234
            ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'workingBalance' => 1234,
                    'clearedBalance' => 1234,
                    'unclearedBalance' => 0
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

        $newName = 'Changed Name';

        $this->put('/api/accounts/' . $account->id, ['name' => $newName])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $newName
                ]
            ]);

        $this->assertEquals($newName, $account->fresh()->name);
    }

    /** @test */
    public function accounts_have_transaction_links()
    {
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $response = $this->getJson('/api/accounts/' . $account->id);

        $this->get($response->json()['links']['transactions'])
            ->assertSuccessful();
    }

    /** @test */
    public function it_lists_accounts()
    {
        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $gql = <<<GQL
query {
  accounts {
    id
    name
  }
}
GQL;

        $this->query($gql)
            ->assertJsonFragment([
                'id' => $account->id,
                'name' => $account->name
            ]);
    }

    /** @test */
    public function it_only_lists_accounts_of_current_user()
    {
        $account = factory(Account::class)->create();

        $gql = <<<GQL
query {
  accounts {
    id
  }
}
GQL;

        $this->query($gql)
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

        $gql = <<<GQL
query {
  accounts {
    id
    balance
  }
}
GQL;

        $this->query($gql)
            ->assertJsonFragment([
                'id' => $account->id,
                'balance' => $transaction->amount
            ]);
    }

}
