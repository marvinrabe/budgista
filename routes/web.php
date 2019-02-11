<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', env('APP_URL'))->name('app');
Route::redirect('/login', env('APP_URL'))->name('login');
Route::redirect('/verify/{token}', env('APP_URL'))->name('email.verify');
Route::redirect('/reset-password/{token}', env('APP_URL'))->name('password.reset');
Route::redirect('{any}', env('APP_URL'))->where('any', '^(?!api).*$');
