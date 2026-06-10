<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::prefix('user')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('me/{id}', [UserController::class, 'getUser']);
        Route::get('address/{id}', [UserController::class, 'getAddress']);
        Route::put('userUpdate/{id}', [UserController::class, 'updateUser']);
        Route::put('addressUpdate/{id}', [UserController::class, 'updateAddress']);
        Route::put('passwordUpdate/{id}', [UserController::class, 'updatePassword']);
        Route::put('deleteAccount/{id}', [UserController::class, 'destroy']);
        Route::post('avatar', [UserController::class, 'updateAvatar']);

        Route::get('collection/{id}', [UserController::class, 'getCollection']);
        Route::delete('removeFromCollection/{id}', [UserController::class, 'removeFromCollection']);

        Route::get('trades/{id}', [UserController::class, 'getTrades']);
        Route::get('trades/show/{id}', [UserController::class, 'showTrade']);
        Route::post('trades/create', [UserController::class, 'createTrade']);
        Route::post('trades/update/{trade}', [UserController::class, 'updateTrade']);
        Route::delete('trades/delete/{id}', [UserController::Class, 'deleteTrade']);

    });
});