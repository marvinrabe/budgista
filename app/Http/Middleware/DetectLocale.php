<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Locale;

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
        $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);

        if (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
        }

        if (empty($locale)) {
            $locale = $request->getPreferredLanguage();
        }

        \Locale::setDefault($locale);

        list($language,) = explode('_', $locale, 1);

        app()->setLocale($language);

        return $next($request);
    }
}