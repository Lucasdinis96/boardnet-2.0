<?php

use App\Http\Controllers\BoardgameController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;


Route::get('/boardgames', [BoardgameController::class, 'index']);
Route::get('/boardgames/{id}', [BoardgameController::class, 'show']);

Route::get('/trades', [TradeController::class, 'index']);
Route::get('/trades/{id}', [TradeController::class, 'show']);

Route::get('/cities/search', [CityController::class, 'search']);
require __DIR__.'/api/auth.php';
require __DIR__.'/api/profile.php';




