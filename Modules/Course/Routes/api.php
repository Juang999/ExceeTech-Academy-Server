<?php

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

Route::middleware(['auth:api', 'verified'])->prefix('course')->group(function () {
    Route::controller(Api\CategoryCourseController::class)->prefix('category-course')->group(function () {
        Route::get('/', 'index')->middleware('role_has_permission:category_course.read');
        Route::post('/', 'store')->middleware('role_has_permission:category_course.create');
        Route::get('/{id}', 'show')->middleware('role_has_permission:category_course.read');
        Route::put('/{id}', 'update')->middleware('role_has_permission:category_course.update');
        Route::delete('/{id}', 'destroy')->middleware('role_has_permission:category_course.delete');
    });
});
