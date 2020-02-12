<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::inertia('/', 'Welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('accounts', AccountController::class)->except('index');
    Route::get('budget/{month?}', BudgetController::class)->name('budget');
    Route::resource('clearedTransactions', ClearedTransactionController::class)->only(['store', 'destroy']);
    Route::resource('transactions', TransactionController::class)->except(['index', 'show']);
    Route::get('statistics', StatisticsController::class)->name('statistics');
});

