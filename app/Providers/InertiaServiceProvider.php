<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'user' => function () {
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->load(['accounts', 'categories']);
                    $user->accounts->each(fn($account) => $account->append('balance'));
                    return $user;
                }
                return null;
            },
            'flash' => function () {
                return Session::get('flash_notification') ?? [];
            },
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);
    }
}
