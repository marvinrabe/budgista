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

    Route::get('/user', 'API\UserController@show')->name('user');

    Route::get('/month/{month?}', 'API\MonthlyBudgetController@show')->name('month');

    Route::resource('categories', 'API\CategoryController', ['only' => [
        'index', 'store', 'update', 'destroy'
    ]]);
    Route::put('/categories/sort', 'API\CategoryController@sort')->name('categories.sort');
    Route::put('/categories/{category}/budget', 'API\CategoryController@budget')->name('categories.budget');

    Route::resource('accounts', 'API\AccountController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);
    Route::get('/accounts/{account}/transactions', 'API\AccountController@transactions')->name('accounts.transactions');

    Route::resource('transactions', 'API\TransactionController', ['only' => [
        'store', 'show', 'update', 'destroy'
    ]]);
    Route::put('/transactions/{transaction}/clear', 'API\TransactionController@clear')->name('transactions.clear');

});