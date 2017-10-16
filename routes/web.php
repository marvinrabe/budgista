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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/settings', 'Auth\SettingsController@get')->name('settings');
    Route::put('/settings', 'Auth\SettingsController@put')->name('settings.store');

    Route::get('budget/{any?}', 'BudgetController@show')->where('any', '.*')->name('budget');

});

