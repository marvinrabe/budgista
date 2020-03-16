<?php

namespace App\Listeners;

use App\User;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCreated;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionUpdated;

class SaveSubscription
{
    /**
     * @param  SubscriptionCreated|SubscriptionUpdated  $event
     */
    public function handle($event)
    {
        if ($event->states !== 'active') {
            // I handle other states manually for now.
            return;
        }

        $user = User::findOrFail($event->passthrough['user_id']);
        $user->subscription_state = 'active';
        $user->subscription_ends_at = $event->next_bill_date;
        $user->paddle_cancel_url = $event->cancel_url;
        $user->paddle_update_url = $event->update_url;
        $user->save();
    }
}
