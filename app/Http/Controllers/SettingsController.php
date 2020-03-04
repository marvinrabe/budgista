<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Laracasts\Flash\Flash;
use MarvinRabe\LaravelIntl\Facades\Currency;
use MarvinRabe\LaravelIntl\Facades\Language;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index');
    }

    public function edit()
    {
        return Inertia::render('Settings/Edit', [
            'currencies' => Currency::all()
        ]);
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

        Flash::success(__('Settings have been saved.'));

        return Redirect::back();
    }
}
