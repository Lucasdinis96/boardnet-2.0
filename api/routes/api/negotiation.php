<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Negotiation\NegotiationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/negotiations', [NegotiationController::class,'index']);
    Route::get('/negotiations/buyer', [NegotiationController::class,'getUserNegotiationAsBuyer']);
    Route::get('/negotiations/seller', [NegotiationController::class,'getUserNegotiationAsSeller']);
    Route::get('/negotiations/{id}', [NegotiationController::class,'show']);
    Route::post('/negotiations/{id}/shipped', [NegotiationController::class, 'shipped']);
    Route::post('/negotiations/delivered', [NegotiationController::class, 'delivered']);
});