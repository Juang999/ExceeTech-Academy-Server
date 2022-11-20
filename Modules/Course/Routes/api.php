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

    Route::controller(Api\CourseController::class)->prefix('course')->group(function () {
        Route::get('/', 'index');
        Route::get('/{course}', 'show');
        Route::post('/', 'store');
        Route::put('/{course}', 'update');
        Route::delete('/{course}', 'destroy');
    });

    Route::controller(Api\MentorCourseController::class)->prefix('mentor')->group(function () {
        Route::get('/{course_id}', 'index');
        Route::post('/', 'store');
        Route::get('/{user_id}', 'show');
        Route::delete('/{mentorCourse}', 'destroy');
    });

    Route::controller(Api\RequirementController::class)->prefix('requirement')->group(function () {
        Route::post('/', 'store');
        Route::delete('/{requirementCourse}', 'destroy');
    });
});
