<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageAccountsTest extends TestCase
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

}