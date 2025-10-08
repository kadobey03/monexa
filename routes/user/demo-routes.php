<?php

use App\Http\Controllers\User\DemoTradingController;
use Illuminate\Support\Facades\Route;

// Demo Trading Routes for Users
Route::middleware(['auth', 'verified'])->prefix('demo')->name('demo.')->group(function () {
    // Demo trading dashboard
    Route::get('/dashboard', [DemoTradingController::class, 'dashboard'])->name('dashboard');

    // Demo trading interface
    Route::get('/trade', [DemoTradingController::class, 'trade'])->name('trade');

    // Execute demo trade
    Route::post('/execute', [DemoTradingController::class, 'executeTrade'])->name('execute');

    // Close demo trade
    Route::post('/close/{id}', [DemoTradingController::class, 'closeTrade'])->name('close');

    // Demo trade history
    Route::get('/history', [DemoTradingController::class, 'history'])->name('history');

    // Reset demo account
    Route::post('/reset', [DemoTradingController::class, 'resetAccount'])->name('reset');

    // Toggle demo mode
    Route::post('/toggle-mode', [DemoTradingController::class, 'toggleDemoMode'])->name('toggle-mode');
});
