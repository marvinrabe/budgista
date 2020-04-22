<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController
{

    public function __invoke()
    {
        if (Auth::user()->subscription_state == 'trial') {
            return Redirect::to('/welcome');
        }

        return Redirect::to('/budget');
    }

}
