<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SettingsController
{

    public function get()
    {
        return View::make('auth.settings')
            ->with('user', Auth::user());
    }

    public function put()
    {
        $user = Auth::user();

        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'locale' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('settings')
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $user->name = Input::get('name');
        $user->email = Input::get('email');

        if (!empty(Input::get('password'))) {
            $user->password = Input::get('password');
        }

        $user->locale = Input::get('locale');
        $user->save();

        Session::flash('success', trans('Account settings saved.'));
        return redirect()->route('settings');
    }

}