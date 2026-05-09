<?php

use App\Http\Controllers\BoardgameController;
use Illuminate\Support\Facades\Route;

Route::prefix('boardgames')->group (function () {
    Route::get('/getAll', [BoardgameController::class, 'index']);
    Route::get('/show/{id}', [BoardgameController::class, 'show']);
    Route::get('/search', [BoardgameController::class, 'search']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/addCollection', [BoardgameController::class, 'addCollection']);
        Route::post('/removeCollection', [BoardgameController::class, 'removeCollection']);
        Route::get('checkCollection/{userId}/{boardgameId}', [BoardgameController::class, 'checkCollection']);  
    });
});
