<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TradeController;

Route::prefix('trades')->group(function () {
    Route::get('/getAll', [TradeController::class, 'index']);
    Route::get('/show/{id}', [TradeController::class, 'show']);
    Route::get('/filters', [TradeController::class, 'filters']);
});
