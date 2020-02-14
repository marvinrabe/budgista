<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Rules\ValidPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{

    public function edit()
    {
        return Inertia::render('User/Edit');
    }

    public function email()
    {
        /**
         * @var User $user
         */
        $user = Auth()->user();

        request()->validate([
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => [
                'required',
                new ValidPassword()
            ]
        ]);

        $user->fill([
            'email' => request('email')
        ]);

        $user->forceFill([
            'email_verified_at' => null
        ]);

        $user->save();

        $user->sendEmailVerificationNotification();

        return Redirect::back();
    }

    public function password()
    {
        request()->validate([
            'password' => [
                'required',
                'string',
                new ValidPassword()
            ],
            'new_password' => ['required', 'string', 'min:8']
        ]);

        Auth()->user()->update([
            'password' => bcrypt(request('new_password'))
        ]);

        return Redirect::back();
    }

    public function delete()
    {
        return Inertia::render('User/Delete');
    }

    public function destroy()
    {
        request()->validate([
            'password' => [
                'required',
                'string',
                new ValidPassword()
            ],
            'feedback' => 'nullable|string'
        ]);

        Auth()->user()->terminate(request('feedback'));
    }

}
