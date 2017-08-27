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

Route::get('/js/lang/{locale}.js', function ($lang) {
    $strings = Cache::rememberForever($lang . '.js', function () use ($lang) {
        $files = [
            resource_path('lang/' . config('app.fallback_locale') . '/javascript.php'),
            resource_path('lang/' . $lang . '/javascript.php')
        ];

        $strings = [];

        foreach ($files as $file) {
            if(!file_exists($file)) {
                continue;
            }

            $strings = array_merge($strings, require $file);
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/settings', 'Auth\SettingsController@get')->name('settings');
    Route::put('/settings', 'Auth\SettingsController@put')->name('settings.store');

    Route::resource('budgets', 'BudgetController');
    Route::group(['prefix' => 'budgets/{budget}', 'middleware' => ['can:view,budget']], function () {

        Route::resource('accounts', 'AccountController', ['except' => [
            'index'
        ]]);
        Route::resource('categories', 'CategoryController', ['except' => [
            'index'
        ]]);
        Route::resource('transactions', 'TransactionController', ['except' => [
            'index'
        ]]);

        Route::get('/month/{month?}', 'SheetController@index')->name('sheet');

        Route::get('/categories/{category}/budget/{month}', 'CategoryController@budget')->name('categories.budget');
        Route::put('/categories/{category}/budget/{month}', 'CategoryController@storeBudget')->name('categories.storeBudget');

        Route::put('/transactions/{transaction}/clear', 'TransactionController@clear')->name('transactions.clear');

    });

});

