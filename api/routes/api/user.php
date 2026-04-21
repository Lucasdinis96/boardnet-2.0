<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\CollectionController;



Route::prefix('user')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me/{id}', [UserController::class, 'getUser']);
        Route::get('adress/{id}', [UserController::class, 'getAdress']);
        Route::put('userUpdate/{id}', [UserController::class, 'updateUser']);
        Route::put('adressUpdate/{id}', [UserController::class, 'updateAdress']);
        Route::put('passwordUpdate/{id}', [UserController::class, 'updatePassword']);
        Route::put('deleteAccount/{id}', [UserController::class, 'destroy']);
    });
});
Route::put('/user/update', [UserController::class, 'update']);
Route::delete('/user/delete', [UserController::class, 'destroy']);

Route::get('/profile/my-trades', [TradeController::class, 'myTrades']);
Route::get('/profile/my-trades/store', [TradeController::class, 'store']);
Route::put('/profile/my-trades/{trade}/update', [TradeController::class, 'update']);
Route::delete('/profile/my-trades/delete/{trade}', [TradeController::class, 'destroy']);
Route::delete('/profile/my-trades/{trade}/boardgame/{boardgame}', [TradeController::class, 'detachBoardgame']);

Route::get('/profile/collection', [CollectionController::class, 'index']);
Route::post('/collection', [CollectionController::class, 'add']);
Route::delete('/collection/{collection}', [CollectionController::class, 'remove']);
