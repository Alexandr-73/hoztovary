<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvotorWebhookController;

Route::post('/evotor/webhook', [EvotorWebhookController::class, 'handle']);
