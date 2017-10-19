<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SettingsController
{

    public function get()
    {
        return view('auth.settings')->with('user', Auth::user());
    }

    public function put(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'locale' => 'required',
            'currency' => 'required'
        ]);

        $user->update(
            request([
                'name',
                'email',
                'locale',
                'currency'
            ])
        );

        if (!empty(request('password'))) {
            $user->password = bcrypt(request('password'));
            $user->save();
        }

        Session::flash('success', trans('Account settings saved.'));

        return back();
    }

}