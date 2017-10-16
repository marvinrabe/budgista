<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use Auth;

class UserController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }

}
