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
Route::controller(Api\SignController::class)->group( function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// logout
Route::post('logout', [Api\SignController::class, 'logout'])->middleware('auth:api');

// verify account
Route::controller(Api\VerificationController::class)->prefix('email')->group( function () {
    // verifyEmail
    Route::get('verify', 'notVerified')->name('verification.notice');
    Route::get('verify/{id}/{hash}', 'verify')->middleware(['auth:api', 'signed'])->name('verification.verify');
    Route::post('verification-notification', 'resendEmail')->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

    // forgotPassword
    Route::post('forgot-password', 'forgotPassword')->middleware('guest')->name('password.email');
});

// main features
Route::middleware(['auth:api', 'verified'])->group( function () {
    // authorization
    Route::prefix('authorization')->group( function () {
        // roleController
        Route::controller(Api\RoleController::class)->group( function () {
            Route::get('role', 'index')->middleware('role_has_permission:role.read');
            Route::post('role', 'store')->middleware('role_has_permission:role.create');
            Route::get('role/{id}', 'show')->middleware('role_has_permission:role.read');
            Route::put('role/{id}', 'update')->middleware('role_has_permission:role.update');
        });
        // permissionController
        Route::controller(Api\PermissionController::class)->group( function () {
            Route::get('permission', 'index')->middleware('role_has_permission:permission.read');
            Route::post('permission', 'store')->middleware('role_has_permission:permission.create');
            Route::get('permission/{id}', 'show')->middleware('role_has_permission:permission-read');
            Route::put('permission/{id}', 'update')->middleware('role_has_permission:permission.update');
        });
    });

    // userController
    Route::controller(Api\UserController::class)->group( function () {
        Route::get('user', 'index')->middleware('role_has_permission:user.read');
        Route::post('user', 'store')->middleware('role_has_permission:user.store');
        Route::get('user/{id}', 'show')->middleware('role_has_permission:user.read');
        Route::put('user/{id}', 'update')->middleware('role_has_permission:user.update');
        Route::delete('user/{id}', 'delete')->middleware('role_has_permission:user.delete');
        Route::put('user-change-role/{id}', 'changeRoleUser')->middleware('role_has_permission:user.update');
        // Route::put('ban-user/{id}', 'banUser')->middleware('role_has_permission:user.ban');
        Route::get('profile', 'detailProfile');
        Route::patch('profile', 'updateProfile');
        Route::patch('image/upload', 'uploadImage');
    });

    // BanController
    // Route::controller(Api\BanController::class)->group( function () {
    //     Route::get('ban', 'index')->middleware('role_has_permission:ban.read');
    // });

    // Route::controller(Api\ProfileController::class)->group( function () {
    //     Route::get('profile', 'detailProfile');
    //     Route::put('profile', 'updateProfile');
    // });
});
