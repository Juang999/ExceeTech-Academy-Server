<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as Api;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// register & login
Route::post('register', [Api\UserController::class, 'register']);
Route::post('login', [Api\UserController::class, 'login']);

// verify account
Route::get('/email/verify', [Api\VerificationController::class, 'notVerified'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [Api\VerificationController::class, 'verify'])->middleware(['auth:api', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [Api\VerificationController::class, 'resendEmail'])->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

// reset password
Route::post('/forgot-password', [Api\VerificationController::class, 'forgotPassword'])->middleware('guest')->name('password.email');

// main features
Route::middleware(['auth:api', 'verified'])->group( function () {
    Route::get('profile', [Api\UserController::class, 'profile']);

    // authorization
    Route::prefix('authorization')->group( function () {
        Route::apiResource('role', Api\RoleController::class)->parameters(['role' => 'id']);
        Route::apiResource('permission', Api\PermissionController::class)->parameters(['permission' => 'id'])->only('index', 'show');
    });

    // register
    Route::post('register-from-admin', [Api\UserController::class, 'registerClient'])->middleware('role_has_permission:create-user');
});
