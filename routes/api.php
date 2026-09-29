<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'service' => 'gmf-backend',
    ]);
});

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::put('/user/password', [AuthController::class, 'changePassword']);
});

// Protected CRUD routes (require authentication)
Route::middleware(['App\Http\Middleware\EnsureTokenIsValid'])->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('pricing', PricingPlanController::class);
});

// Certificate routes
// Public endpoint - view certificate preview by certificate number
Route::get('/certificates/search', [CertificateController::class, 'searchByWelderId']);
Route::get('/certificates/preview/{certificateNo}', [CertificateController::class, 'show'])->where('certificateNo', '.*');

// Protected certificate routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Get full certificate details (owner or admin only)
    Route::get('/certificates/{certificateNo}/detail', [CertificateController::class, 'detail'])->where('certificateNo', '.*');

    // Download certificate PDF (owner or admin only)
    Route::get('/certificates/{certificateNo}/pdf', [CertificateController::class, 'downloadPdf'])->where('certificateNo', '.*');

    // List all certificates for the authenticated user
    Route::get('/user/certificates', [CertificateController::class, 'listUserCertificates']);

    // Admin: link unlinked certificate to user
    Route::post('/admin/certificates/{id}/link-user', [CertificateController::class, 'linkToUser']);
});
