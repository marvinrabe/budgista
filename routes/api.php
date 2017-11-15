<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api']], function () {

    /*
     * User
     */
    Route::get('user', 'API\UserController@show')->name('user');

    /*
     * Budget
     */
    Route::get('month/{month?}', 'API\MonthlyBudgetController@show')->name('month');

    /*
     * Categories
     */
    Route::put('categories/sort', 'API\CategoryController@sort')->name('categories.sort');
    Route::put('categories/{category}/budget', 'API\CategoryController@budget')->name('categories.budget');
    Route::apiResource('categories', 'API\CategoryController');

    /*
     * Accounts
     */
    Route::get('accounts/{account}/transactions', 'API\TransactionController@index')->name('accounts.transactions');
    Route::apiResource('accounts', 'API\AccountController');

    /*
     * Transactions
     */
    Route::put('transactions/{transaction}/clear', 'API\TransactionController@clear')->name('transactions.clear');
    Route::apiResource('transactions', 'API\TransactionController', ['except' => [
        'index'
    ]]);

});