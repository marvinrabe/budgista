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

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {

    /*
     * User
     */
    Route::get('user', 'UserController@show')->name('user');
    Route::put('user', 'UserController@update')->name('user.update');
    Route::delete('user', 'UserController@destroy')->name('user.destroy');

    Route::post('user/email', 'UserController@email')->name('user.email');
    Route::post('user/password', 'UserController@password')->name('user.password');
    Route::post('user/reset', 'UserController@reset')->name('user.reset');

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
    Route::put('groups/{group}/collapse', 'GroupController@collapse');
    Route::apiResource('groups', 'GroupController');
});

Route::fallback(function() {
    return response()->json(['message' => 'Not Found!'], 404);
});
