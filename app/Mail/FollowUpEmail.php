<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this
            ->from('marvin@budgista.com', 'Marvin (from Budgista)')
            ->subject('Quick Tip for Starting Your Budget')
            ->text('email.followUp');
    }
}
