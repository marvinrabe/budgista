<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
use App\User;
use App\Scopes\UserScope;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $response = $this
            ->post('/register', [
                'name' => $this->faker->name,
                'email' => 'john@example.com',
                'password' => 'i-love-laravel',
                'terms' => true,
            ])
            ->assertRedirect('/setup');

        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());

        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));

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
                'name' => $this->faker->name,
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->email === $user->email;
        });
    }

    /**
     * @dataProvider locales
     */
    public function testSetsLocale($locale, $currency)
    {
        App::setLocale($locale);

        $this->withoutMiddleware(DetectLocale::class);

        $this
            ->post('/register', [
                'name' => $this->faker->name,
                'email' => 'john.doe@example.com',
                'password' => 'password',
                'terms' => true
            ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertEquals($locale, $user->language);
        $this->assertEquals($locale, $user->locale);
        $this->assertEquals($currency, $user->currency);
    }

    public function locales()
    {
        return [
            ['de', 'EUR'],
            ['en', 'USD']
        ];
    }

}
