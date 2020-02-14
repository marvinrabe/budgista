<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function () {
    Route::redirect('/', '/budget');
    Route::resource('accounts', AccountController::class)->except('index');
    Route::get('budget/{month?}', BudgetController::class)->name('budget');
    Route::resource('clearedTransactions', ClearedTransactionController::class)->only(['store', 'destroy']);
    Route::resource('transactions', TransactionController::class)->except(['index', 'show']);
    Route::get('profile', [Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('profile/email', [Controllers\UserController::class, 'email'])->name('user.email');
    Route::post('profile/password', [Controllers\UserController::class, 'password'])->name('user.password');
    Route::get('profile/terminate', [Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::post('profile/terminate', [Controllers\UserController::class, 'destroy'])->name('user.destroy');
    Route::get('settings', [Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('statistics', StatisticsController::class)->name('statistics');
});
