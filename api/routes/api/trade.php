<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TradeController;


Route::get('/trades/getAll', [TradeController::class, 'index']);
Route::get('/trades/show/{id}', [TradeController::class, 'show']);