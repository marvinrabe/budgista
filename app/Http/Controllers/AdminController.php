<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {
        if (Gate::denies('is-admin')) {
            return abort(403);
        }

        $users = User::paginate(15);

        return view('admin')->with(compact('users'));
    }

}