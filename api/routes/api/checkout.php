<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Checkout\CheckoutController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [CheckoutController::class,'store']);
});