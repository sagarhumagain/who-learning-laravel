<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\StaffCategoryController;
use App\Http\Controllers\StaffTypeController;

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

Route::resource('contracts/v1/', ContractController::class);
Route::resource('contract-types/v1/', ContractTypeController::class);
Route::resource('courses/v1/', CourseController::class);
Route::resource('designations/v1/', DesignationController::class);
Route::resource('pillars/v1/', PillarController::class);
Route::resource('staff-categories/v1/', StaffCategoryController::class);
Route::resource('staff-types/v1/', StaffTypeController::class);
