<?php

namespace App\Listeners;

use App\User;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCancelled;

class CancelSubscription
{
    public function handle(SubscriptionCancelled $event)
    {
        $user = User::findOrFail($event->passthrough['user_id']);
        $user->subscription_state = 'cancelled';
        $user->subscription_ends_at = $event->cancellation_effective_date;
        $user->paddle_cancel_url = null;
        $user->paddle_update_url = null;
        $user->save();
    }
}
