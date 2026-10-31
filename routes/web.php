<?php

use App\Http\Controllers\PayController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/pay', [PayController::class, 'index'])->name('pay');
});

Route::post('/webhooks/mercadopago', [WebhookController::class, 'mercadopago'])->name('webhooks.mercadopago');

require __DIR__.'/settings.php';
