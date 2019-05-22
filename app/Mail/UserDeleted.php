<?php

namespace App\Mail;

use App\Models\DeletedUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct(DeletedUser $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->view('email.userDeleted')->with(['user' => $this->user]);
    }
}
