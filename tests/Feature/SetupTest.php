<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class SetupTest extends TestCase
{

    public function testListCurrencies()
    {
        $this->signIn()
            ->get('/setup')
            ->assertInertiaViewIs('Setup/Index')
            ->assertHasProp('currencies');
    }

    public function testSetCurrency()
    {
        $user = factory(User::class)->create([
            'currency' => 'EUR'
        ]);

        $this->signIn($user)
            ->post('/setup', [
                'currency' => 'USD'
            ])
            ->assertRedirect('/setup/categories');

        $this->assertEquals('USD', $user->fresh()->currency);
    }

    public function testValidCurrency()
    {
        $user = factory(User::class)->create([
            'currency' => 'EUR'
        ]);

        $this->signIn($user)
            ->from('/setup')
            ->post('/setup', [
                'currency' => 'Cute Kitties'
            ])
            ->assertSessionHasErrors('currency')
            ->assertRedirect('/setup');

        $this->assertNotEquals('Cute Kitties', $user->fresh()->currency);
    }

    public function testListCategories()
    {
        $this->signIn()
            ->get('/setup/categories')
            ->assertInertiaViewIs('Setup/Categories')
            ->assertHasProp('samples');
    }

    public function testCreateCategories()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->categories);

        $this->signIn($user)
            ->post('/setup/categories', [
                'categories' => [0, 1, 2]
            ])
            ->assertRedirect('/setup/accounts');

        $this->assertCount(3, $user->fresh()->categories);
    }

    public function testNoCategories()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->categories);

        $this->signIn($user)
            ->post('/setup/categories', [])
            ->assertRedirect('/setup/accounts');

        $this->assertCount(0, $user->refresh()->categories);
    }

    public function testIgnoreInvalidCategories()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->categories);

        $this->signIn($user)
            ->post('/setup/categories', [
                'categories' => [9999]
            ])
            ->assertRedirect('/setup/accounts');

        $this->assertCount(0, $user->fresh()->categories);
    }

    public function testCreateAccounts()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->accounts);

        $this->signIn($user)
            ->post('/setup/accounts', [
                'accounts' => [
                    ['name' => 'Cash', 'amount' => 123],
                    ['name' => 'Visa', 'amount' => 999]
                ]
            ])
            ->assertRedirect('/');

        $this->assertCount(2, $user->refresh()->accounts);

        $account = $user->accounts->first();
        $this->assertEquals('Cash', $account->name);
        $this->assertEquals(123, $account->balance);
    }

    public function testNoAccounts()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->accounts);

        $this->signIn($user)
            ->post('/setup/accounts', [])
            ->assertRedirect('/');

        $this->assertCount(0, $user->refresh()->accounts);
    }

    public function testIgnoreInvalidAccounts()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->accounts);

        $this->signIn($user)
            ->post('/setup/accounts', [
                'accounts' => [
                    ['name' => '', 'amount' => null],
                    ['name' => null],
                    []
                ]
            ])
            ->assertRedirect('/');

        $this->assertCount(0, $user->fresh()->accounts);
    }

}
