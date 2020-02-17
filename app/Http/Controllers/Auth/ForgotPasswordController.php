<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laracasts\Flash\Flash;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/PasswordsEmail');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        Flash::success(__("An email with a password reset link has been sent."));

        return back()->with('status', trans($response));
    }
}
