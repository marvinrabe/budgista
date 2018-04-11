<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    public function index()
    {
        if (Cookie::has('rememberMe')) {
            return redirect()->route('app');
        }

        return view('static.home');
    }

}
