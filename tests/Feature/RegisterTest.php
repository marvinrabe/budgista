<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
use App\Http\Middleware\LoadUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() {
        parent::setUp();
        Notification::fake();
    }

    protected function registerUser()
    {
        $this
            ->post('/api/auth/register', [
                'email' => 'john.doe@example.com',
                'password' => 'secret',
                'terms' => true
            ]);

        return User::where('email', 'john.doe@example.com')->first();
    }

    /** @test */
    public function user_is_stored_in_database()
    {
        $this->registerUser();

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com'
        ]);
    }

    /** @test */
    public function it_sends_verify_email()
    {
        $this->registerUser();

        $user = User::where('email', 'john.doe@example.com')->first();

        Notification::assertSentTo(
            $user, \Illuminate\Auth\Notifications\VerifyEmail::class
        );
    }

    /** @test */
    public function user_has_sample_content()
    {
        $user = $this->registerUser();

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Groceries', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Cash', $user->accounts()->first()->name);
    }

    /** @test */
    public function user_has_localized_sample_content()
    {
        app()->setLocale('de');

        $this->withoutMiddleware(DetectLocale::class);

        $user = $this->registerUser();

        $this->assertEquals('de', $user->language);

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Lebensmittel', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Bargeld', $user->accounts()->first()->name);
    }

    /** @test */
    public function it_requires_accepted_terms()
    {
        $this
            ->withExceptionHandling()
            ->post('/api/auth/register', [
                'email' => 'john.doe@example.com',
                'password' => 'secret',
                'terms' => false
            ])
            ->assertSessionHasErrors(['terms']);
    }

    /** @test */
    public function it_assigns_wallet_icon_to_cash_account()
    {
        $user = $this->registerUser();

        $account = $user->accounts()->where('name', 'Cash')->first();

        $this->assertEquals('wallet', $account->icon);
    }

}
