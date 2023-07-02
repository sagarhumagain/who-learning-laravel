<?php

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Models\User;

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
    return redirect('login');
});
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');





Route::get('/epub', [BaseController::class, 'epub']);
Route::post('/epub', [BaseController::class, 'epubReader'])->name('epubReader');





Auth::routes();

Route::get('{any}', function () {
    return view('welcome');
})->where('any', '^(?!pgadmin).*');




// Route::group(['middleware' => ['auth']], function () {
//     // Route::resource('roles', RoleController::class);
//     // Route::resource('users', UserController::class);
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });
