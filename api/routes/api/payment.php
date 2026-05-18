<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Payment\PaymentController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post(
        '/negotiations/{id}/payments',
        [PaymentController::class, 'store']
    );
});