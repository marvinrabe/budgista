<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountIconTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function it_defaults_to_credit_card_icon()
    {
        $account = factory(Account::class)->raw();

        $this->post("/api/accounts", $account)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $account['name'],
                    'icon' => 'credit-card'
                ]
            ]);

        $this->assertDatabaseHas('accounts', [
            'name' => $account['name'],
            'icon' => 'credit-card',
            'user_id' => Auth()->id()
        ]);
    }

    /** @test */
    public function it_allows_icon_updates()
    {
        $account = factory(Account::class)
            ->create([
                'user_id' => Auth()->id()
            ]);

        $this
            ->put('/api/accounts/' . $account->id, [
                'name' => $account->name,
                'icon' => 'wallet'
            ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'icon' => 'wallet'
                ]
            ]);

        $this->assertEquals('wallet', $account->fresh()->icon);
    }

    /** @test */
    public function it_validates_icon_names()
    {
        $account = factory(Account::class)
            ->create([
                'user_id' => Auth()->id()
            ]);

        $this
            ->put('/api/accounts/' . $account->id, [
                'name' => $account->name,
                'icon' => 'invalid-icon-name'
            ])
            ->assertSessionHasErrors('icon');
    }

}
