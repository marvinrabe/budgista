<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RequiresSubscription
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()
            && $request->user()->subscription_ends_at
            && $request->user()->subscription_ends_at->isBefore(now()->subDay())) {
            return Redirect::route('settings.billing');
        }
        return $next($request);
    }
}
