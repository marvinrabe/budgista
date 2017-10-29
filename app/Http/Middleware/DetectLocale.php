<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Propaganistas\LaravelIntl\Facades\Language;

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
        $languages = array_keys(Language::all());

        if (Auth::guest()) {
            $language = $request->getPreferredLanguage($languages);

            if (Cookie::has('language')) {
                $language = Cookie::get('language');
            }
        } else {
            $language = Auth::user()->language;
        }

        if (!in_array($language, $languages)) {
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
