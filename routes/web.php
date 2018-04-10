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

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::view('/legal', 'static.legal')->name('legal');
    Route::view('/terms', 'static.terms')->name('terms');
    Route::view('/privacy', 'static.privacy')->name('privacy');

    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');
});

Route::view('/auth/login', 'app')->name('login');
Route::view('/auth/register', 'app')->name('register');
Route::view('/app', 'app')->name('app');

Route::group(['prefix' => 'app'], function() {
    Route::view('{any}', 'app')->where('any', '.*');
});
Route::group(['prefix' => 'auth'], function() {
    Route::view('{any}', 'auth')->where('any', '.*');
});
