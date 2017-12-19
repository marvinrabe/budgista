<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_profile()
    {
        $this->signIn()
            ->get('/api/user')
            ->assertJson([
                'data' => [
                    'email' => Auth()->user()->email,
                    'name' => Auth()->user()->name,
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
        $this->signIn()
            ->put('/api/user', [
                'name' => 'New Name',
                'language' => 'de',
                'locale' => 'de',
                'currency' => 'USD',
            ])
            ->assertJson([
                'data' => [
                    'name' => 'New Name',
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
        $this->signIn()
            ->put('/api/user', [
                'name' => 'New Name',
                'language' => 'xx',
                'locale' => 'de',
                'currency' => 'USD',
            ])
            ->assertSessionHasErrors('language');
    }

    /** @test */
    public function it_requires_a_valid_locale()
    {
        $this->signIn()
            ->put('/api/user', [
                'name' => 'New Name',
                'language' => 'de',
                'locale' => 'xx',
                'currency' => 'USD',
            ])
            ->assertSessionHasErrors('locale');
    }

    /** @test */
    public function it_requires_a_valid_currency()
    {
        $this->signIn()
            ->put('/api/user', [
                'name' => 'New Name',
                'language' => 'de',
                'locale' => 'de',
                'currency' => 'XXX',
            ])
            ->assertSessionHasErrors('currency');
    }

}
