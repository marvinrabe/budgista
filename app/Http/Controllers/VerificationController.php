<?php

namespace App\Http\Controllers;

use App\Auth\EmailTokenRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $record = resolve(EmailTokenRepository::class)->find('token', request('token'));

        if ($record === null) {
            return response()->json([
                'error' => trans('errors.404'),
            ], 404);
        }

        $user = User::where('email', $record->email)->first();

        if ($user === null) {
            return response()->json([
                'error' => trans('errors.404'),
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([], 200);
        }

        $user->markEmailAsVerified();

        event(new Verified($request->user()));

        return response()->json([], 200);
    }

    /**
     * Resend the email verification notification.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'error' => trans('auth.verified'),
            ], 422);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([], 200);
    }

}
