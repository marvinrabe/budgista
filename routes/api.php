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

    Route::resource('budgets', 'API\BudgetController', ['only' => [
        'show'
    ]]);
    Route::get('/budgets/{budget}/accounts', 'API\BudgetController@accounts')->name('budgets.accounts');
    Route::get('/budgets/{budget}/month/{month?}', 'API\BudgetController@month')->name('budgets.month');
    Route::put('/budgets/{budget}/sort', 'API\BudgetController@sort')->name('budgets.sort');

    Route::resource('categories', 'API\CategoryController', ['only' => [
        'store', 'update', 'destroy'
    ]]);
    Route::put('/categories/{category}/budget', 'API\CategoryController@budget')->name('categories.budget');

    Route::resource('accounts', 'API\AccountController', ['only' => [
        'store', 'show', 'update', 'destroy'
    ]]);
    Route::get('/accounts/{account}/transactions', 'API\AccountController@transactions')->name('accounts.transactions');

    Route::resource('transactions', 'API\TransactionController', ['only' => [
        'store', 'show', 'update', 'destroy'
    ]]);
    Route::put('/transactions/{transaction}/clear', 'API\TransactionController@clear')->name('transactions.clear');

});