<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome')->name('root');
});

Route::get('/email/verify', [Web\VerifyController::class, 'notVerified'])->name('verification.notice');
// Route::get('/email/verify/{id}/{hash}', [Web\VerifyController::class, 'verify'])->middleware(['auth:api', 'signed'])->name('verification.verify');

Route::get('verify-email', [Web\VerifyController::class, 'hasVerifiedEmail'])->name('hasVerifiedEmail');
