<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ViewErrorBag;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        if (Auth::check()) {
            return $this->handleAuthenticatedCall($user);
        }

        return $this->handleGuestCall($user);
    }

    protected function handleGuestCall($googleUser)
    {
        $user = User::firstWhere('google_id', $googleUser->id);

        if (!$user) {
            if (User::where('email', $googleUser->email)->count()) {
                return Redirect::route('login')->withErrors([
                    'google' => __('There is already an user with your email address. Please login using your password.')
                ]);
            }

            $user = User::create([
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
                'language' => App::getLocale(),
                'locale' => App::getLocale(),
                'currency' => App::getLocale() == 'en' ? 'USD' : 'EUR'
            ]);

            event(new Registered($user));

            Auth::login($user, true);

            return Redirect::route('setup');
        }

        Auth::login($user, true);

        return Redirect::home();
    }

    protected function handleAuthenticatedCall($googleUser)
    {
        if (User::where('google_id', $googleUser->id)->count()) {
            return Redirect::route('user.edit')->withErrors([
                'google' => __('There is already an user with this Google account.')
            ]);
        }

        Auth::user()->update([
            'google_id' => $googleUser->id
        ]);

        return Redirect::route('user.edit');
    }

    public function destroy()
    {
        if (!Auth::user()->has_password) {
            return Redirect::back()->withErrors([
                'google' => __('Your account has no password. Please add a password before removing your Google account.')
            ]);
        }

        Auth::user()->update([
            'google_id' => null
        ]);

        return Redirect::back();
    }
}
