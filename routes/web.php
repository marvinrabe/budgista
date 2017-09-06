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

    Route::resource('budgets', 'BudgetController');
    Route::group(['prefix' => 'budgets/{budget}', 'middleware' => ['can:view,budget']], function () {

        Route::get('/accounts/{account}', 'BudgetController@account')->name('budgets.account');

        Route::resource('transactions', 'TransactionController', ['except' => [
            'index'
        ]]);

        Route::put('/transactions/{transaction}/clear', 'TransactionController@clear')->name('transactions.clear');

    });

});

