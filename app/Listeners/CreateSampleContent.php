<?php

namespace App\Listeners;

use App\UserOnboarding;
use Illuminate\Auth\Events\Registered;

class CreateSampleContent
{

    /**
     * Create sample content for newly registered users.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle($event)
    {
        UserOnboarding::for($event->user);
    }

}
