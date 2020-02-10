<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
use App\Models\User;
use App\Scopes\UserScope;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatesSampleContent()
    {
        $this
            ->post('/register', [
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertGreaterThan(0, $user->categories()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Groceries', $user->categories()->withoutGlobalScope(UserScope::class)->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Cash', $user->accounts()->withoutGlobalScope(UserScope::class)->first()->name);
    }

    public function testLocalizedSampleContent()
    {
        App::setLocale('de');

        $this->withoutMiddleware(DetectLocale::class);

        $this
            ->post('/register', [
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertEquals('de', $user->language);

        $this->assertGreaterThan(0, $user->categories()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Lebensmittel', $user->categories()->withoutGlobalScope(UserScope::class)->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->withoutGlobalScope(UserScope::class)->count());
        $this->assertEquals('Bargeld', $user->accounts()->withoutGlobalScope(UserScope::class)->first()->name);
    }

    public function testCashAccountHasWalletIcon()
    {
        $this
            ->post('/register', [
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        $account = $user->accounts()->withoutGlobalScope(UserScope::class)->where('name', 'Cash')->first();

        $this->assertEquals('wallet', $account->icon);
    }

    public function testUserCanViewARegistrationForm()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertInertiaViewIs('Auth/Register');
    }

    public function testUserCannotViewARegistrationFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    public function testUserCanRegister()
    {
        Event::fake();

        $response = $this->post('/register', [
            'email' => 'john@example.com',
            'password' => 'i-love-laravel',
            'terms' => true,
        ]);

        $response->assertRedirect('/');
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('i-love-laravel', $user->password));
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    public function testUserCannotRegisterWithoutEmail()
    {
        $response = $this->from('/register')->post('/register', [
            'email' => '',
            'password' => 'i-love-laravel',
            'terms' => true,
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithInvalidEmail()
    {
        $response = $this->from('/register')->post('/register', [
            'email' => 'invalid-email',
            'password' => 'i-love-laravel',
            'terms' => true,
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutPassword()
    {
        $response = $this->from('/register')->post('/register', [
            'email' => 'john@example.com',
            'password' => '',
            'terms' => true
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutAcceptingTerms()
    {
        $response = $this->from('/register')->post('/register', [
            'email' => 'john@example.com',
            'password' => '',
            'terms' => false
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('terms');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testRegisteredEvent()
    {
        Event::fake();

        $this
            ->post('/register', [
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->email === $user->email;
        });
    }

}
