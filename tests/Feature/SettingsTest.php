<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\Transaction;
use App\Month;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateSettings()
    {
        $this
            ->signIn()
            ->from('/settings')
            ->post('/settings', [
                'language' => 'de',
                'locale' => 'de',
                'currency' => 'USD',
            ])
            ->assertRedirect('/settings');
    }

    public function testRequiresValidLanguage()
    {
        $this
            ->signIn()
            ->post('/settings', [
                'language' => 'xx',
                'locale' => 'de',
                'currency' => 'USD',
            ])
            ->assertSessionHasErrors('language');
    }

    public function testRequiresValidLocale()
    {
        $this
            ->signIn()
            ->post('/settings', [
                'language' => 'de',
                'locale' => 'xx',
                'currency' => 'USD',
            ])
            ->assertSessionHasErrors('locale');
    }

    public function testRequiresValidCurrency()
    {
        $this
            ->signIn()
            ->post('/settings', [
                'language' => 'de',
                'locale' => 'de',
                'currency' => 'xxx',
            ])
            ->assertSessionHasErrors('currency');
    }

}
