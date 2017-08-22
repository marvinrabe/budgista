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
    Route::resource('budgets', 'BudgetController');
    Route::group(['prefix' => 'budget/{budget}', 'middleware' => ['can:view,budget']], function () {
        Route::get('/month/{month?}', 'SheetController@index')->name('sheet');
        Route::resource('accounts', 'AccountController', ['except' => [
            'index'
        ]]);
        Route::resource('categories', 'CategoryController', ['only' => [
            'create', 'store', 'edit', 'destroy', 'update'
        ]]);
        Route::get('/categories/{category}/budget/{month}', 'CategoryController@budget')->name('categories.budget');
        Route::put('/categories/{category}/budget/{month}', 'CategoryController@storeBudget')->name('categories.storeBudget');

        Route::group(['prefix' => 'accounts/{account}'], function () {
            Route::resource('transactions', 'TransactionController', ['only' => [
                'create', 'store', 'edit', 'destroy', 'update'
            ]]);
            Route::put('/transactions/{transaction}/clear', 'TransactionController@clear')->name('transactions.clear');
        });
    });
});

