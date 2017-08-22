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
        $rules = array(
            'locale' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('settings')
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $user = Auth::user();

        $user->locale = Input::get('locale');
        $user->save();

        Session::flash('message', 'Account settings saved!');
        return redirect()->route('settings');
    }

}