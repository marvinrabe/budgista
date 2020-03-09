<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('login/google', [Controllers\Auth\GoogleController::class, 'redirectToProvider']);
Route::get('login/google/callback', [Controllers\Auth\GoogleController::class, 'handleProviderCallback']);

Route::group(['middleware' => ['auth']], function () {
    Route::redirect('/', '/budget')->name('home');

    /*
     * Accounts
     */
    Route::resource('accounts', AccountController::class);
    Route::get('accounts/{account}/future', [Controllers\AccountController::class, 'future'])->name('accounts.future');
    Route::post('accounts/{account}/reconcile',
        [Controllers\AccountController::class, 'reconcile'])->name('accounts.reconcile');

    /*
     * Budget
     */
    Route::get('budget/{month?}', [Controllers\BudgetController::class, 'index'])->name('budget');
    Route::get('budget/{month}/uncategorized',
        [Controllers\BudgetController::class, 'uncategorized'])->name('budget.uncategorized');
    Route::get('budget/{month}/categories/{category}',
        [Controllers\BudgetController::class, 'show'])->name('budget.show');
    Route::post('budget/{month}/categories/{category}',
        [Controllers\BudgetController::class, 'store'])->name('budget.store');
    Route::get('tabularBudget/{month?}', TabularBudget::class)->name('budget.tabular');

    /*
     * Categories
     */
    Route::resource('categories', CategoryController::class)->except(['show', 'destroy']);
    Route::post('categories/{category}/delete',
        [Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/sort', [Controllers\CategoryController::class, 'sort'])->name('categories.sort');

    /*
     * Transactions
     */
    Route::resource('transactions', TransactionController::class)->except(['index', 'show']);
    Route::resource('clearedTransactions', ClearedTransactionController::class)->only(['store', 'destroy']);

    /*
     * Settings
     */
    Route::get('settings', [Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::get('settings/edit', [Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/profile', [Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/profile/email', [Controllers\UserController::class, 'email'])->name('user.email');
    Route::delete('profile/google', [Controllers\Auth\GoogleController::class, 'destroy'])->name('google.destroy');
    Route::post('/profile/password', [Controllers\UserController::class, 'password'])->name('user.password');
    Route::get('/profile/terminate', [Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::post('/profile/terminate', [Controllers\UserController::class, 'destroy'])->name('user.destroy');

    /*
     * Statistics
     */
    Route::get('statistics', [Controllers\StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('statistics/netWorth', [Controllers\StatisticsController::class, 'netWorth'])->name('statistics.netWorth');
    Route::get('statistics/incomeVsExpense',  [Controllers\StatisticsController::class, 'incomeVsExpense'])->name('statistics.incomeVsExpense');
    Route::get('statistics/expense',  [Controllers\StatisticsController::class, 'expense'])->name('statistics.expense');
    Route::get('statistics/incomes',  [Controllers\StatisticsController::class, 'income'])->name('statistics.income');

    /*
     * Setup
     */
    Route::get('setup', [Controllers\SetupController::class, 'index'])->name('setup');
    Route::post('setup', [Controllers\SetupController::class, 'postIndex']);
    Route::get('setup/2', [Controllers\SetupController::class, 'step2']);
    Route::post('setup/2', [Controllers\SetupController::class, 'postStep2']);
    Route::get('setup/3', [Controllers\SetupController::class, 'step3']);
    Route::post('setup/3', [Controllers\SetupController::class, 'postStep3']);
    Route::get('setup/4', [Controllers\SetupController::class, 'step4']);
});
