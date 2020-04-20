<?php

namespace App\Listeners;

use App\User;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCreated;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionPaymentSucceeded;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionUpdated;

class ExtendSubscription
{
    /**
     * @param  SubscriptionPaymentSucceeded  $event
     */
    public function handle($event)
    {
        $user = User::findOrFail($event->passthrough['user_id']);
        $user->subscription_ends_at = $event->next_bill_date;
        $user->save();
    }
}
