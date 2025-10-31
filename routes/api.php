<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\FinancialApiController;
use App\Http\Controllers\Api\DepositApiController;
use App\Http\Controllers\Api\WithdrawalApiController;
use App\Http\Controllers\Api\PlanApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\Admin\AdminUserApiController;
use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Http\Controllers\ImageController;

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

// Authentication Routes
Route::prefix('auth')->middleware('throttle:60,1')->group(function () {
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthApiController::class, 'refresh'])->middleware('auth:sanctum');
});

// Authenticated API Routes
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    // User Profile & KYC
    Route::prefix('user')->group(function () {
        Route::get('profile', [UserApiController::class, 'profile']);
        Route::put('profile', [UserApiController::class, 'updateProfile']);
        Route::post('kyc/upload', [UserApiController::class, 'uploadKyc']);
        Route::get('kyc/status', [UserApiController::class, 'kycStatus']);
    });

    // Financial Operations
    Route::prefix('financial')->group(function () {
        Route::get('balance', [FinancialApiController::class, 'balance']);

        // Deposits
        Route::get('deposits', [DepositApiController::class, 'index']);
        Route::post('deposits', [DepositApiController::class, 'store']);
        Route::get('deposits/{deposit}', [DepositApiController::class, 'show']);

        // Withdrawals
        Route::get('withdrawals', [WithdrawalApiController::class, 'index']);
        Route::post('withdrawals', [WithdrawalApiController::class, 'store']);
        Route::get('withdrawals/{withdrawal}', [WithdrawalApiController::class, 'show']);
    });

    // Investment Plans
    Route::apiResource('plans', PlanApiController::class)->except(['destroy']);
    Route::post('plans/{plan}/invest', [PlanApiController::class, 'invest']);
    Route::get('my-investments', [PlanApiController::class, 'myInvestments']);

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationApiController::class, 'index']);
        Route::get('count', [NotificationApiController::class, 'count']);
        Route::post('{notification}/read', [NotificationApiController::class, 'markAsRead']);
    });
});

// Admin APIs (with admin middleware)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('users', AdminUserApiController::class);
    Route::post('users/{user}/assign-lead', [AdminUserApiController::class, 'assignLead']);
    Route::get('dashboard/stats', [AdminApiController::class, 'dashboardStats']);
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