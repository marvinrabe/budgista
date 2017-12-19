<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelIntl\Facades\Currency;
use Propaganistas\LaravelIntl\Facades\Language;

class UserController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }


    public function update()
    {
        Auth::user()->update(
            request()->validate([
                'name' => 'required',
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
