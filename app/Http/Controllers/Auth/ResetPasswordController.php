<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function showResetForm(Request $request, $token = null)
    {
        return Inertia::render('Auth/PasswordsReset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }
}
