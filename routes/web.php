<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/pay', [PayController::class, 'index'])->name('pay');
});

require __DIR__.'/settings.php';
