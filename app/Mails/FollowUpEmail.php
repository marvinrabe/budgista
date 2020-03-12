<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->from('marvin@budgista.com', 'Marvin (from Budgista)')
            ->subject('One quick question...')
            ->view('email.followUp', ['user' => $this->user])
            ->text('email.followUpText', ['user' => $this->user]);
    }
}
