<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function index()
    {
        if (\Auth::check()) {
            return redirect()->route('app');
        }

        return view('static.welcome');
    }

}
