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

    Route::put('/budgets/{budget}/sort', 'BudgetController@sort')->name('budgets.sort');

    Route::resource('categories', 'API\CategoryController', ['only' => [
        'store', 'update', 'destroy'
    ]]);
    Route::put('/categories/{category}/budget', 'API\CategoryController@budget')->name('categories.budget');

});