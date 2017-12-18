<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function email()
    {
        $user = Auth()->user();

        request()->validate([
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'required'
        ]);

        if (!Hash::check(request('password'), $user->password)) {
            abort(403);
        }

        $user->update([
            'email' => request('email')
        ]);
    }

    public function password()
    {
        $user = Auth()->user();

        request()->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:6'
        ]);

        if (!Hash::check(request('password'), $user->password)) {
            abort(403);
        }

        $user->update([
            'password' => bcrypt(request('new_password'))
        ]);
    }

}
