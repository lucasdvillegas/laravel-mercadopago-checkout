<?php

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/pay', [PayController::class, 'index'])->name('pay');
});

require __DIR__.'/settings.php';
