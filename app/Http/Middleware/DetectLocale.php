<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        $availableLocales = config('app.available_locales');

        $prefferedLocale = $request->getPreferredLanguage($availableLocales);
        $locale = $request->query('lang', $prefferedLocale);

        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }

}
