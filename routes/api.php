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

Route::post('register', [Api\UserController::class, 'register']);
Route::post('login', [Api\UserController::class, 'logiin']);

Route::prefix('email')->middleware('auth:api')->group(function () {
    Route::get('verify/{id}', [Api\VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('resend', [Api\VerificationController::class, 'resend'])->name('verification.resend');
    Route::get('verified', [Api\VerificationController::class, 'verified']);
});

