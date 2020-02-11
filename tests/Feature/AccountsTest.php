<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreAccount()
    {
        $this
            ->signIn()
            ->from('/accounts/create')
            ->post('/accounts', [
                'name' => 'New Account',
                'icon' => 'wallet',
                'tracking' => true
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('accounts', [
            'name' => 'New Account',
            'icon' => 'wallet',
            'tracking' => true,
            'user_id' => Auth()->id()
        ]);
    }

    public function testDefaultIcon()
    {
        $account = factory(Account::class)->raw();

        $this
            ->signIn()
            ->post("/accounts", $account);

        $this->assertDatabaseHas('accounts', [
            'name' => $account['name'],
            'icon' => 'credit-card',
            'user_id' => Auth()->id()
        ]);
    }

    public function testInitialBalance()
    {
        $this
            ->signIn()
            ->from('/accounts/create')
            ->post('/accounts', [
                'name' => 'New Account',
                'icon' => 'wallet',
                'tracking' => true,
                'initial_balance' => 1234
            ])
            ->assertRedirect();

        $account = Auth::user()->accounts()->latest()->first();

        $this->assertEquals(1234, $account->balance);
    }

    public function testRequireName()
    {
        $this
            ->signIn()
            ->from('/accounts/create')
            ->post('/accounts', [])
            ->assertSessionHasErrors('name');
    }

    public function testRequireValidIcon()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->put("/accounts/{$account->id}", [
                'name' => $account->name,
                'icon' => 'invalid-icon-name'
            ])
            ->assertSessionHasErrors('icon');
    }

    public function testUpdateAccount()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->from("/accounts/{$account->id}/edit")
            ->put("/accounts/{$account->id}", [
                'name' => 'New Name',
                'icon' => 'wallet',
                'tracking' => true
            ])
            ->assertRedirect();

        $account->refresh();

        $this->assertEquals('New Name', $account->name);
        $this->assertEquals('wallet', $account->icon);
        $this->assertTrue($account->tracking);
    }

    public function testCanNotUpdateOtherUsersAccounts()
    {
        $otherAccount = factory(Account::class)->create();

        $nameBefore = $otherAccount->name;

        $this
            ->signIn()
            ->from("/accounts/{$otherAccount->id}/edit")
            ->put("/accounts/{$otherAccount->id}", [
                'name' => 'New Name',
                'icon' => 'wallet',
                'tracking' => true
            ])
            ->assertNotFound();

        $this->assertEquals($nameBefore, $otherAccount->fresh()->name);
    }

    /** @test */
    public function testDeleteAccount()
    {
        $account = factory(Account::class)->create();

        $this
            ->signIn($account->user)
            ->from("/accounts/{$account->id}/edit")
            ->delete("/accounts/{$account->id}");

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id
        ]);
    }


    /** @test */
    public function testCanNotDeleteOtherUsersAccounts()
    {
        $otherAccount = factory(Account::class)->create();

        $this
            ->signIn()
            ->from("/accounts/{$otherAccount->id}/edit")
            ->delete("/accounts/{$otherAccount->id}")
            ->assertNotFound();

        $this->assertDatabaseHas('accounts', [
            'id' => $otherAccount->id
        ]);
    }

    public function testAccountBalance()
    {
        $transaction = factory(Transaction::class)->create();

        $this->signIn($transaction->user);

        $this->assertEquals($transaction->amount, $transaction->account->balance);
    }

}
