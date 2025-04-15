<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/mercadopago', [CheckoutController::class, 'handleWebhook'])->name('webhook.mercadopago');
