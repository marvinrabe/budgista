<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $reason;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->view('email.userDeleted')->with(['reason' => $this->reason]);
    }
}
