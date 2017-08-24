<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        if ($user = Auth::user()) {

            \Locale::setDefault($user->locale);
            setlocale(LC_ALL, $user->locale);
            Carbon::setLocale($user->locale);

            list($language,) = explode('_', $user->locale, 1);
            app()->setLocale($language);

            $response = $next($request);

            // Set Cookie
            if (!Cookie::has('locale')) {
                $response->withCookie(Cookie::forever('locale', $user->locale));
            }

            return $response;
        }

        return $next($request);
    }
}
