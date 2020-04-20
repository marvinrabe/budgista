<?php

namespace App\Providers;

use App\Listeners;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCancelled;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCreated;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionPaymentSucceeded;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class
        ],
        Authenticated::class => [
            Listeners\LogLastLogin::class,
        ],
        SubscriptionCreated::class => [
            Listeners\SaveSubscription::class
        ],
        SubscriptionUpdated::class => [
            Listeners\SaveSubscription::class
        ],
        SubscriptionCancelled::class => [
            Listeners\CancelSubscription::class
        ],
        SubscriptionPaymentSucceeded::class => [
            Listeners\ExtendSubscription::class
        ]
    ];
}
