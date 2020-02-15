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
use Illuminate\Support\Facades\Response;

Route::group(['middleware' => ['auth:api']], function () {
    /*
     * Categories
     */
    Route::put('categories/sort', 'CategoryController@sort')->name('categories.sort');
    Route::put('categories/{category}/budget', 'CategoryController@budget')->name('categories.budget');

    /*
     * Groups
     */
    Route::put('groups/sort', 'GroupController@sort');
    Route::put('groups/{group}/collapse', 'GroupController@collapse');
});

Route::fallback(function () {
    return Response::json(['message' => 'Not Found!'], 404);
});
