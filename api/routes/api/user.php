<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::prefix('user')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('me/{id}', [UserController::class, 'getUser']);
        Route::get('adress/{id}', [UserController::class, 'getAdress']);
        Route::put('userUpdate/{id}', [UserController::class, 'updateUser']);
        Route::put('adressUpdate/{id}', [UserController::class, 'updateAdress']);
        Route::put('passwordUpdate/{id}', [UserController::class, 'updatePassword']);
        Route::put('deleteAccount/{id}', [UserController::class, 'destroy']);

        Route::get('collection/{id}', [UserController::class, 'getCollection']);
        Route::delete('removeFromCollection/{id}', [UserController::class, 'removeFromCollection']);

        Route::get('trades/{id}', [UserController::class, 'getTrades']);
        Route::get('trades/show/{id}', [UserController::class, 'showTrade']);
        Route::post('trades/create', [UserController::class, 'createTrade']);
        Route::put('trades/update/{trade}', [UserController::class, 'updateTrade']);
        Route::delete('trades/delete/{id}', [UserController::Class, 'deleteTrade']);

    });
});