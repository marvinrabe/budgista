<?php

namespace App\Auth;

use App\Castable;

class EmailToken extends Castable
{

    public $email;
    public $token;
    public $created_at;

}
