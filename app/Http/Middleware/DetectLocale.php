<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DetectLocale
{
    public function handle($request, Closure $next)
    {
        $availableLocales = config('app.available_locales');

        if (Auth::check()) {
            $locale = Auth()->user()->language;
        } else {
            $preferredLocale = $request->getPreferredLanguage($availableLocales);
            $locale = $request->query('lang', $preferredLocale);
        }

        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
