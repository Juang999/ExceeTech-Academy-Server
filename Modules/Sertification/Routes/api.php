<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->prefix('/sertification')->group(function () {
    Route::controller(Api\CategorySertificationController::class)->prefix('category-sertification')->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
    });
});