<?php

use App\Http\Controllers\PaidTransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('paidTransactions', PaidTransactionController::class)->only(['store', 'destroy']);
});

Route::fallback(function () {
    return Response::json(['message' => 'Not Found!'], 404);
});
