<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Month;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function updateProfile($data = [])
    {
        return $this
            ->signIn()
            ->put('/api/user', array_merge([
                'language' => 'de',
                'locale' => 'de',
                'currency' => 'USD',
            ], $data));
    }

    /** @test */
    public function it_returns_profile()
    {
        $this->signIn()
            ->get('/api/user')
            ->assertJson([
                'data' => [
                    'email' => Auth()->user()->email,
                    'localization' => [
                        'language' => Auth()->user()->language,
                        'locale' => Auth()->user()->locale,
                        'currency' => Auth()->user()->currency,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_update_user_data()
    {
        $this
            ->updateProfile()
            ->assertJson([
                'data' => [
                    'localization' => [
                        'language' => 'de',
                        'locale' => 'de',
                        'currency' => 'USD',
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_requires_a_valid_language()
    {
        $this
            ->updateProfile([
                'language' => 'xx'
            ])
            ->assertSessionHasErrors('language');
    }

    /** @test */
    public function it_requires_a_valid_locale()
    {
        $this
            ->updateProfile([
                'locale' => 'xx'
            ])
            ->assertSessionHasErrors('locale');
    }

    /** @test */
    public function it_requires_a_valid_currency()
    {
        $this
            ->updateProfile([
                'currency' => 'XXX'
            ])
            ->assertSessionHasErrors('currency');
    }

    /** @test */
    public function it_can_reset_every_data()
    {
        $this->signIn();

        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);
        factory(Transaction::class)->create([
            'account_id' => $account->id
        ]);

        $category = factory(Category::class)->create([
            'user_id' => Auth()->id()
        ]);
        $budget = $category->budgetIn(Month::current());
        $budget->amount = 1234;
        $budget->save();

        $this
            ->post('/api/user/reset', [
                'password' => 'secret'
            ]);

        $this->assertCount(0, $account->transactions);
        $this->assertCount(0, $category->budgets);
        $this->assertEquals(0, $account->workingBalance());
    }

    /** @test */
    public function it_requires_a_valid_password_for_reset()
    {
        $this
            ->signIn()
            ->post('/api/user/reset', [
                'password' => 'not-valid'
            ])
            ->assertStatus(403);
    }

}
