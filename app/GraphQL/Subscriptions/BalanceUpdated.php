<?php

namespace App\GraphQL\Subscriptions;

use App\Models\Account;
use Illuminate\Http\Request;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;

class BalanceUpdated extends GraphQLSubscription
{
    /**
     * Check if subscriber is allowed to listen to the subscription.
     * @param  \Nuwave\Lighthouse\Subscriptions\Subscriber $subscriber
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    public function authorize(Subscriber $subscriber, Request $request): bool
    {
        return $subscriber->context->user !== null;
    }

    /**
     * Filter which subscribers should receive the subscription.
     * @param  \Nuwave\Lighthouse\Subscriptions\Subscriber $subscriber
     * @param  Account $account
     * @return bool
     */
    public function filter(Subscriber $subscriber, $account): bool
    {
        return $account->ownedBy($subscriber->context->user);
    }
}
