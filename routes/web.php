<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::inertia('/', 'Welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('accounts', AccountController::class)->except('index');
    Route::resource('transactions', TransactionController::class)->except(['index', 'show']);
});

