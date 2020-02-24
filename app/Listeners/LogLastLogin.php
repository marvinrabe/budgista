<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Authenticated;

class LogLastLogin
{
    public function handle(Authenticated $event)
    {
        if ($this->userLoggedInToday($event->user)) {
            return;
        }

        $event->user->timestamps = false;

        $event->user->update([
            'last_login_at' => now()
        ]);
    }

    protected function userLoggedInToday($user)
    {
        return optional($user->last_login_at)->isAfter(Carbon::today()->startOfDay());
    }
}
