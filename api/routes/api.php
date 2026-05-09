<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;



Route::get('/cities/search', [CityController::class, 'search']);

require __DIR__.'/api/auth.php';
require __DIR__.'/api/user.php';
require __DIR__.'/api/boardgames.php';
require __DIR__.'/api/trade.php';




