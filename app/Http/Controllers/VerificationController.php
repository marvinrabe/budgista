<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after verification.
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        /**
         * @var User $user
         */
        $user = User::find($request->route('id'));

        if ($user && $user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath());
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
