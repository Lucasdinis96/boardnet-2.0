<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\CollectionController;



    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::put('/profile/update/{id}', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::get('/profile/my-trades', [TradeController::class, 'myTrades']);
    Route::get('/profile/my-trades/store', [TradeController::class, 'store']);
    Route::put('/profile/my-trades/{trade}/update', [TradeController::class, 'update']);
    Route::delete('/profile/my-trades/delete/{trade}', [TradeController::class, 'destroy']);
    Route::delete('/profile/my-trades/{trade}/boardgame/{boardgame}', [TradeController::class, 'detachBoardgame']);

    Route::get('/profile/collection', [CollectionController::class, 'index']);
    Route::post('/collection', [CollectionController::class, 'add']);
    Route::delete('/collection/{collection}', [CollectionController::class, 'remove']);
