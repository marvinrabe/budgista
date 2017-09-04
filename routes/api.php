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

    Route::get('/budgets/{budget}/month/{month?}', 'BudgetController@month')->name('budgets.month');

    Route::resource('categories', 'CategoryController', ['only' => [
        'store', 'update', 'destroy'
    ]]);
    Route::put('/categories/{category}/budget', 'CategoryController@budget')->name('categories.budget');


});