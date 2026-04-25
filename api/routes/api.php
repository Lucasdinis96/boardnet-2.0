<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;

Route::get('/trades', [TradeController::class, 'index']);
Route::get('/trades/{id}', [TradeController::class, 'show']);

Route::get('/cities/search', [CityController::class, 'search']);

require __DIR__.'/api/auth.php';
require __DIR__.'/api/user.php';
require __DIR__.'/api/boardgames.php';




