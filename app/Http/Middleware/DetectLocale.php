<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DetectLocale
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validLanguages = config('app.available_locales');

        $language = $request->getPreferredLanguage($validLanguages);

        if (Cookie::has('language')) {
            $language = Cookie::get('language');
        } elseif (Auth::check()) {
            $language = Auth::user()->language;
        }

        if (!in_array($language, $validLanguages)) {
            $language = config('app.fallback_locale');
        }

        app()->setLocale($language);

        $response = $next($request);

        if (Cookie::get('language', null) != $language) {
            $response->withCookie(Cookie::forever('language', $language));
        }

        return $response;
    }

}
