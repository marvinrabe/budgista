<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
use App\Models\User;
use App\Scopes\UserScope;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

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
    public function it_dispatches_registered_event()
    {
        Event::fake();

        $user = $this->registerUser();

        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->email === $user->email;
        });
    }

    /** @test */
    public function user_has_sample_content()
    {
        $user = $this->registerUser();

        $this->assertGreaterThan(0, $user->categories()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Groceries', $user->categories()->withoutGlobalScope(UserScope::class)->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Cash', $user->accounts()->withoutGlobalScope(UserScope::class)->first()->name);
    }

    /** @test */
    public function user_has_localized_sample_content()
    {
        app()->setLocale('de');

        $this->withoutMiddleware(DetectLocale::class);

        $user = $this->registerUser();

        $this->assertEquals('de', $user->language);

        $this->assertGreaterThan(0, $user->categories()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Lebensmittel', $user->categories()->withoutGlobalScope(UserScope::class)->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Bargeld', $user->accounts()->withoutGlobalScope(UserScope::class)->first()->name);
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

        $account = $user->accounts()->withoutGlobalScope(UserScope::class)->where('name', 'Cash')->first();

        $this->assertEquals('wallet', $account->icon);
    }

}
