<?php

namespace App\Listeners;

use App\Services\CreateSamples;
use Illuminate\Auth\Events\Registered;

class CreateSamplesForNewUser
{

    /**
     * Create sample content for newly registered users.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle($event)
    {
        CreateSamples::for ($event->user);
    }

}
