<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function getTooManyLoginAttemptsMessage()
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    public function testUserCanViewALoginForm()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertInertiaViewIs('Auth/Login');
    }

    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function testRememberMeFunctionality()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $user = $user->fresh();

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithout()
    {
        $user = factory(User::class)->create([
            'password' => null,
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('i-love-laravel'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotLoginWithEmailThatDoesNotExist()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'nobody@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCanLogout()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        foreach (range(0, 5) as $_) {
            $response = $this->from('/login')->post('/login', [
                'email' => $user->email,
                'password' => 'invalid-password',
            ]);
        }

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertRegExp(
            $this->getTooManyLoginAttemptsMessage(),
            collect(
                $response
                    ->baseResponse
                    ->getSession()
                    ->get('errors')
                    ->getBag('default')
                    ->get('email')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

}
