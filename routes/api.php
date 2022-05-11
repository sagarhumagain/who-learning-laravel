<?php
namespace Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\ContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\StaffCategoryController;
use App\Http\Controllers\StaffTypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContractTypeDesignationController;
use App\Http\Controllers\Api\ContractTypeStaffCategoryController;
use App\Http\Controllers\Api\ContractTypeStaffTypeController;
use App\Http\Controllers\Api\DesignationStaffCategoryController;
use App\Http\Controllers\Api\DesignationStaffTypeController;
use App\Http\Controllers\Api\StaffCategoryStaffTypeController;

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


Route::group(
    ['prefix' => 'v1', 'middleware' => ['auth:sanctum']],
    function () {
        Route::apiResources(['user'=>UserController::class]);
        Route::apiResources(['contract'=>ContractController::class]);

        Route::get('/profile', [UserController::class, 'getProfile']);
        // Route::apiResources(['role'         =>'RoleController']);

        // Route::apiResources(['permission'   =>'PermissionController']);
        // Route::post('updatePassword', 'ProfileController@updatePassword');
        // Route::apiResources(['profile'      =>'ProfileController']);

        Route::post('/read_all', [BaseController::class, 'readAll']);
        Route::post('/read_notification', [BaseController::class, 'read']);
        Route::post('/unread_notification', [BaseController::class, 'unread']);
        Route::get('/notifications', [BaseController::class, 'notifications']);


        Route::resource('/contracts', ContractController::class);
        Route::resource('/contract-types', ContractTypeController::class);
        Route::resource('/courses', CourseController::class);
        Route::resource('/designations', DesignationController::class);
        Route::resource('/pillars', PillarController::class);
        Route::resource('/staff-categories', StaffCategoryController::class);
        Route::resource('/staff-types', StaffTypeController::class);
        Route::resource('/course-categories', CourseCategoryController::class);

        Route::get('/designation-staff-category', [ContractTypeDesignationController::class, 'show']);
        Route::get('/designation-staff-category', [ContractTypeStaffCategoryController::class, 'show']);
        Route::get('/designation-staff-category', [ContractTypeStaffTypeController::class, 'show']);
        Route::get('/designation-staff-category', [DesignationStaffCategoryController::class, 'show']);
        Route::get('/designation-staff-type', [DesignationStaffTypeController::class, 'show']);
        Route::get('/designation-staff-category', [StaffCategoryStaffTypeController::class, 'show']);
    }
);
