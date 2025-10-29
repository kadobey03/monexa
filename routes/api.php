<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserImportController;
use App\Http\Controllers\Api\UserStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/create-account', [ApiAuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Import Routes - Protected with custom header
Route::prefix('import')->name('api.import.')->group(function () {
    Route::post('/users', [UserImportController::class, 'importUser'])->name('users');
    Route::post('/users/bulk', [UserImportController::class, 'bulkImportUsers'])->name('users.bulk');
});

// User Status Routes - Protected with custom header
Route::prefix('users')->name('api.users.')->group(function () {
    Route::get('/status/statistics', [UserStatusController::class, 'getStatusStatistics'])->name('status.statistics');
    Route::get('/status', [UserStatusController::class, 'getUsersStatus'])->name('status');
    Route::get('/status/{identifier}', [UserStatusController::class, 'getUserStatus'])->name('status.single');
});

// Admin API Routes - Web authentication for admin dashboard
Route::middleware(['web'])->prefix('admin')->name('api.admin.')->group(function () {
    
    // Leads Management API Routes
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', 'App\Http\Controllers\Api\Admin\LeadController@index')->name('index');
        Route::post('/', 'App\Http\Controllers\Api\Admin\LeadController@store')->name('store');
        Route::get('/statistics', 'App\Http\Controllers\Api\Admin\LeadController@statistics')->name('statistics');
        Route::get('/options', 'App\Http\Controllers\Api\Admin\LeadController@options')->name('options');
        Route::get('/search', 'App\Http\Controllers\Api\Admin\LeadController@search')->name('search');
        Route::get('/{lead}', 'App\Http\Controllers\Api\Admin\LeadController@show')->name('show');
        Route::patch('/{id}', 'App\Http\Controllers\Api\Admin\LeadController@update')->name('update');
        Route::delete('/{id}', 'App\Http\Controllers\Api\Admin\LeadController@destroy')->name('destroy');
        Route::post('/bulk', 'App\Http\Controllers\Api\Admin\LeadController@bulk')->name('bulk');
        
        // Table Configuration Routes
        Route::prefix('table')->name('table.')->group(function () {
            Route::get('/configuration', 'App\Http\Controllers\Api\Admin\LeadTableController@getConfig')->name('configuration');
            Route::post('/settings', 'App\Http\Controllers\Api\Admin\LeadTableController@updateSettings')->name('settings');
            Route::post('/reset', 'App\Http\Controllers\Api\Admin\LeadTableController@resetConfig')->name('reset');
        });
    });
    
    // Phone Actions Routes
    Route::prefix('phone')->name('phone.')->group(function () {
        Route::post('/{lead}/actions', 'App\Http\Controllers\Api\Admin\PhoneController@getActions')->name('actions');
        Route::post('/{lead}/call', 'App\Http\Controllers\Api\Admin\PhoneController@initiateCall')->name('call');
        Route::post('/{lead}/whatsapp', 'App\Http\Controllers\Api\Admin\PhoneController@whatsapp')->name('whatsapp');
        Route::get('/{lead}/history', 'App\Http\Controllers\Api\Admin\PhoneController@callHistory')->name('history');
    });
    
    // Import Routes
    Route::prefix('import')->name('import.')->group(function () {
        Route::post('/upload', 'App\Http\Controllers\Api\Admin\ImportController@upload')->name('upload');
        Route::post('/{importId}/process', 'App\Http\Controllers\Api\Admin\ImportController@process')->name('process');
        Route::get('/{importId}/status', 'App\Http\Controllers\Api\Admin\ImportController@status')->name('status');
        Route::get('/history', 'App\Http\Controllers\Api\Admin\ImportController@history')->name('history');
    });
    
    // Export Routes
    Route::prefix('export')->name('export.')->group(function () {
        Route::post('/start', 'App\Http\Controllers\Api\Admin\ExportController@start')->name('start');
        Route::get('/{exportId}/status', 'App\Http\Controllers\Api\Admin\ExportController@status')->name('status');
        Route::get('/download', 'App\Http\Controllers\Api\Admin\ExportController@download')->name('download');
        Route::get('/history', 'App\Http\Controllers\Api\Admin\ExportController@history')->name('history');
    });
});

// Image management routes
Route::prefix('images')->name('api.images.')->group(function () {
    // Public routes (if needed)
    Route::get('/', [ImageController::class, 'index'])->name('index');
    Route::get('/{id}', [ImageController::class, 'show'])->name('show');
    Route::get('/ref/{refKey}', [ImageController::class, 'getByRefKey'])->name('by-ref-key');
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [ImageController::class, 'store'])->name('store');
        Route::post('/multiple', [ImageController::class, 'uploadMultiple'])->name('upload-multiple');
        Route::put('/{id}', [ImageController::class, 'update'])->name('update');
        Route::delete('/{id}', [ImageController::class, 'destroy'])->name('destroy');
    });
});