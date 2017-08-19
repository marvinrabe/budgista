<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;

class HomeController extends Controller
{

    public function index()
    {
        return redirect()->route('budgets.index');
    }

}
