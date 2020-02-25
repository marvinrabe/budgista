<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\User;
use App\Rules\ValidPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laracasts\Flash\Flash;

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

        Flash::success(__('Email Address has been updated.'));

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
            'password' => Hash::make(request('new_password'))
        ]);

        Flash::success(__('Password has been updated.'));

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

        Flash::success(__('User account deleted. Thank you for using Budgista.'));

        return Redirect::route('login');
    }

}
