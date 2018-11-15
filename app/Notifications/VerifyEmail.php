<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as DefaultVerifyEmailNotification;

class VerifyEmail extends DefaultVerifyEmailNotification
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    protected function verificationUrl($notifiable)
    {
        return url(config('app.url') . route('email.verify', $this->token, false));
    }

}
