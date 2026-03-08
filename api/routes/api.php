<?php

use App\Http\Controllers\BoardgameController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/boardgames', [BoardgameController::class, 'index']);
Route::get('/boardgames/{id}', [BoardgameController::class, 'show']);

Route::get('/trades', [TradeController::class, 'index']);
Route::get('/trades/{id}', [TradeController::class, 'show']);

Route::get('/cities/search', [CityController::class, 'search']);

    
Route::get('/profile', [ProfileController::class, 'edit']);
Route::patch('/profile', [ProfileController::class, 'update']);
Route::delete('/profile', [ProfileController::class, 'destroy']);

Route::get('/profile/my-trades', [TradeController::class, 'myTrades']);
Route::get('/profile/my-trades/create', [TradeController::class, 'getBoardgames']);
Route::post('profile/my-trades/store', [TradeController::class, 'store']);
Route::get('/profile/my-trades/{trade}/edit', [TradeController::class, 'edit']);
Route::put('/profile/my-trades/{trade}/update', [TradeController::class, 'update']);
Route::delete('/profile/my-trades/{trade}/delete', [TradeController::class, 'destroy']);
Route::delete('/profile/my-trades/{trade}/boardgame/{boardgame}', [TradeController::class, 'detachBoardgame']);

Route::get('/profile/collection', [CollectionController::class, 'index']);
Route::post('/collection', [CollectionController::class, 'add']);
Route::delete('/collection/{collection}', [CollectionController::class, 'remove']);

Route::middleware('auth')->group(function () {

});
