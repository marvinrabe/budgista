<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Auth\SanctumController;
use App\Http\Controllers\Api\PaidTransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::post('sanctum/login', [SanctumController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('me', function () {
        return ['user' => Auth()->user()];
    });

    Route::get('budget/{month}', [BudgetController::class, 'index']);
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('paidTransactions', PaidTransactionController::class)->only(['store', 'destroy']);
});

Route::fallback(function () {
    return Response::json(['message' => 'Not Found!'], 404);
});
