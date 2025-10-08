<?php

use App\Http\Controllers\Admin\DemoManagementController;
use Illuminate\Support\Facades\Route;

// Admin Demo Trading Management Routes
Route::middleware(['isadmin', '2fa'])->prefix('admin/demo')->name('admin.demo.')->group(function () {
    // Demo trading overview
    Route::get('/', [DemoManagementController::class, 'index'])->name('index');

    // Demo users management
    Route::get('/users', [DemoManagementController::class, 'users'])->name('users');

    // Demo trades management
    Route::get('/trades', [DemoManagementController::class, 'trades'])->name('trades');

    // Update user demo balance
    Route::post('/users/{user}/balance', [DemoManagementController::class, 'updateDemoBalance'])->name('update-balance');

    // Reset individual user demo account
    Route::post('/users/{user}/reset', [DemoManagementController::class, 'resetUserDemo'])->name('reset-user');

    // Bulk reset all demo accounts
    Route::post('/bulk-reset', [DemoManagementController::class, 'bulkResetDemo'])->name('bulk-reset');

    // Demo trading statistics
    Route::get('/statistics', [DemoManagementController::class, 'statistics'])->name('statistics');

    // Close demo trade (admin action)
    Route::post('/trades/{trade}/close', [DemoManagementController::class, 'closeDemoTrade'])->name('close-trade');
});
