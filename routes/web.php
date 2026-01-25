<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Laravel\Cashier\Http\Controllers\WebhookController;

Route::post('/webhook/stripe', [WebhookController::class, 'handleWebhook']);

