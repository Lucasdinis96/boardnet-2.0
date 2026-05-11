<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/cities/search', [CityController::class, 'search']);

Route::get('home/games', [HomeController::class, 'getHomeGames']);
Route::get('home/trades', [HomeController::class, 'getHomeTrades']);

require __DIR__.'/api/auth.php';
require __DIR__.'/api/user.php';
require __DIR__.'/api/boardgames.php';
require __DIR__.'/api/trade.php';




