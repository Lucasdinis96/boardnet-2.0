<?php

use App\Http\Controllers\BoardgameController;
use Illuminate\Support\Facades\Route;

Route::get('/boardgames', [BoardgameController::class, 'index']);
Route::get('/boardgames/{id}', [BoardgameController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addCollection', [BoardgameController::class, 'addCollection']);
    Route::post('/removeCollection', [BoardgameController::class, 'removeCollection']);
    Route::get('checkCollection/{userId}/{boardgameId}', [BoardgameController::class, 'checkCollection']);  
});
