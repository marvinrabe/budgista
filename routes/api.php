<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthenticationController@login');
    Route::post('logout', 'AuthenticationController@logout');
    Route::post('register', 'AuthenticationController@register');
    Route::get('refresh', 'AuthenticationController@refresh');
    Route::get('user', 'UserController@show');

});

Route::group(['middleware' => ['auth:api']], function () {

    /*
     * User
     */
    Route::get('user', 'UserController@show')->name('user');
    Route::put('user', 'UserController@update')->name('user.update');
    Route::post('user/email', 'UserController@email')->name('user.email');
    Route::post('user/password', 'UserController@password')->name('user.password');
    Route::post('user/reset', 'UserController@reset')->name('user.reset');

    /*
     * Budget
     */
    Route::get('month/{month?}', 'MonthlyBudgetController@show')->name('month');

    /*
     * Categories
     */
    Route::put('categories/sort', 'CategoryController@sort')->name('categories.sort');
    Route::put('categories/{category}/budget', 'CategoryController@budget')->name('categories.budget');
    Route::apiResource('categories', 'CategoryController');

    /*
     * Groups
     */
    Route::put('groups/sort', 'GroupController@sort');
    Route::apiResource('groups', 'GroupController');

    /*
     * Accounts
     */
    Route::get('accounts/{account}/transactions', 'TransactionController@index')->name('accounts.transactions');
    Route::post('accounts/{account}/reconcile', 'AccountController@reconcile')->name('accounts.reconcile');
    Route::apiResource('accounts', 'AccountController');

    /*
     * Transactions
     */
    Route::put('transactions/{transaction}/clear', 'TransactionController@clear')->name('transactions.clear');
    Route::apiResource('transactions', 'TransactionController', [
        'except' => [
            'index'
        ]
    ]);

});