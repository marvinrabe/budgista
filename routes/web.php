<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function () {
    Route::redirect('/', '/budget');
    Route::resource('accounts', AccountController::class)->except('index');
    Route::get('accounts/{account}/future', [Controllers\AccountController::class, 'future'])->name('accounts.future');
    Route::post('accounts/{account}/reconcile',
        [Controllers\AccountController::class, 'reconcile'])->name('accounts.reconcile');
    Route::get('budget/{month?}', [Controllers\BudgetController::class, 'show'])->name('budget');
    Route::post('budget/{month}/categories/{category}',
        [Controllers\BudgetController::class, 'store'])->name('budget.store');
    Route::resource('categories', CategoryController::class)->except(['index', 'show', 'destroy']);
    Route::post('categories/{category}/delete', [Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/sort', [Controllers\CategoryController::class, 'sort'])->name('categories.sort');
    Route::resource('clearedTransactions', ClearedTransactionController::class)->only(['store', 'destroy']);
    Route::resource('groups', GroupController::class)->except(['index', 'show']);
    Route::post('groups/{group}/collapse', [Controllers\GroupController::class, 'collapse'])->name('groups.collapse');
    Route::post('groups/sort', [Controllers\GroupController::class, 'sort'])->name('groups.sort');
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
