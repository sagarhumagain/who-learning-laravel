<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('{any}', function () {
    return view('welcome');
})->where('any', '^(?!pgadmin).*')->middleware('web');
Auth::routes();

// Route::group(['middleware' => ['auth','sanctum']], function () {
//     // Route::resource('roles', RoleController::class);
//     // Route::resource('users', UserController::class);
//     // Route::resource('products', ProductController::class);
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });
