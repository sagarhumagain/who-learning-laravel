<?php

namespace Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\ContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\StaffCategoryController;
use App\Http\Controllers\StaffTypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContractTypeDesignationController;
use App\Http\Controllers\Api\ContractTypeStaffCategoryController;
use App\Http\Controllers\Api\ContractTypeStaffTypeController;
use App\Http\Controllers\Api\DesignationController;
use App\Http\Controllers\Api\DesignationStaffCategoryController;
use App\Http\Controllers\Api\DesignationStaffTypeController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StaffCategoryStaffTypeController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\SupervisorController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DesignationController as ControllersDesignationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    ['prefix' => 'v1', 'middleware' => ['auth:api']],
    function () {
        Route::post('/enroll/course', [CourseController::class, 'enrollToCourse']);
        Route::get('/course_user', [CourseController::class, 'listEnrolledCourse']);
        Route::group(['middleware' => ['role:super-admin|supervisor|course-admin']], function () {
            Route::apiResources(['user'=>UserController::class]);
            Route::apiResources(['designation' => DesignationController::class]);
            Route::post('/assign-course-to-new-users', [CourseController::class, 'assignCourseToNewUsers']);
            Route::get('/report', [BaseController::class, 'report']);
        });
        Route::get('/get-choices', [BaseController::class, 'getChoices']);

        Route::apiResources(['contract'=>ContractController::class]);

        Route::post('updatePassword', [ProfileController::class, 'updatePassword']);

        Route::apiResources(['profile' => ProfileController::class]);

        // Route::apiResources(['role'         =>'RoleController']);

        // Route::apiResources(['permission'   =>'PermissionController']);

        Route::apiResources(['supervisors' => SupervisorController::class]);


        Route::post('/read_all_notification', [BaseController::class, 'readAll']);
        Route::post('/read_notification', [BaseController::class, 'read']);
        Route::post('/unread_notification', [BaseController::class, 'unread']);
        Route::get('/notifications', [BaseController::class, 'notifications']);


        Route::resource('/contracts', ContractController::class);
        Route::resource('/contract-types', ContractTypeController::class);
        Route::group(['middleware' => ['has_profile']], function () {
            Route::resource('/courses', CourseController::class);
        });
        Route::post('/withdraw-course/{id}', [CourseController::class, 'withdrawCourse']);
        Route::get('/approve/courses', [CourseController::class, 'getApprovalCourseList']);
        Route::put('/update-assigned-course', [CourseController::class, 'updateEnrolledCourse']);

        Route::resource('/designations', ControllersDesignationController::class);
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
        // Route::get('/statistics/top-learner', [StatisticsController::class, 'show']);
        Route::get('/statistics/admin-stats', [StatisticsController::class, 'fetchAdminDashboardStats']);
        Route::get('/statistics/staff-pillar', [StatisticsController::class, 'fetchStaffByPillar']);
        Route::get('/statistics/course-popular', [StatisticsController::class, 'fetchMostPopularCourses']);
        Route::get('/courses/users/pending-approval', [StatisticsController::class, 'fetchPendingApprovals']);
        Route::get('/statistics/course-mandatory', [StatisticsController::class, 'fetchMandatoryCourses']);
        Route::get('/statistics/user-stats', [StatisticsController::class, 'fetchUserDashboardStats']);
        Route::get('/statistics/user-course-completed', [StatisticsController::class, 'fetchUserCompletedCourse']);
        Route::get('/statistics/user-course-deadline', [StatisticsController::class, 'fetchUserUpcomingDeadlines']);
        Route::get('/statistics/user-yearly-progress', [StatisticsController::class, 'fetchUserYearlyProgress']);

        Route::get('/approvals/courses', [CourseController::class, 'listUnapprovedCourses']);
        Route::post('/approve-certificate', [CourseController::class, 'approveCertificate']);

        Route::get('/approve/certificate', [CourseController::class, 'getUnapprovedCertificate']);

        Route::get('/suggest/courses', [CourseController::class, 'listSuggestedCourses']);
        Route::get('/deadlines-exceed', [CourseController::class, 'getExceededDeadlines']);

        Route::get('/users-stats', [StatisticsController::class, 'usersStats']);
        Route::get('/units', [UnitController::class, 'index']);




    }
);


Route::get('/session-status', function () {
    $status = auth()->user() ? 'logged in' : 'logged out';
    return response()->json(['status' => $status]);
})->middleware('auth:api');
