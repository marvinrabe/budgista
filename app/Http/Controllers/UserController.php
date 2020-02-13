<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use App\Rules\ValidPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Propaganistas\LaravelIntl\Facades\Currency;
use Propaganistas\LaravelIntl\Facades\Language;

class UserController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function edit () {
        return Inertia::render('User/Edit');
    }

    public function update()
    {
        Auth::user()->update(
            request()->validate([
                'language' => [
                    'required',
                    Rule::in(config('app.available_locales'))
                ],
                'locale' => [
                    'required',
                    Rule::in(array_keys(Language::all()))
                ],
                'currency' => [
                    'required',
                    Rule::in(array_keys(Currency::all()))
                ],
            ])
        );

        return new UserResource(Auth::user());
    }

    public function delete () {
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

    public function email()
    {
        /**
         * @var User $user
         */
        $user = Auth()->user();

        request()->validate([
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
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

        return new UserResource(Auth::user());
    }

    public function password()
    {
        request()->validate([
            'password' => [
                'required',
                'string',
                new ValidPassword()
            ],
            'new_password' => 'required|string|min:6'
        ]);

        Auth()->user()->update([
            'password' => bcrypt(request('new_password'))
        ]);
    }

}
