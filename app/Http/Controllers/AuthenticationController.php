<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthenticationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) { // ->setTTL(7200)
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register()
    {
        request()->validate([
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'terms' => 'required|accepted'
        ]);

        $user = User::create([
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'language' => app()->getLocale(),
            'locale' => app()->getLocale()
        ]);

        event(new Registered($user));
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (TokenExpiredException $exception) {
            return abort(401);
        }
    }

    protected function respondWithToken($token)
    {
        return response()
            ->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ])
            ->header('Authorization', $token);
    }

}