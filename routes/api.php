<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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