<?php

use App\Http\Controllers\Webhooks\AbacatePayWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/abacatepay',[AbacatePayWebhookController::class, 'handle']);