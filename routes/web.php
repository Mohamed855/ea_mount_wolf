<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// home page route
Route::get('/', [HomeController::class, 'index']) -> name('home');

// Auth routes
Route::get('sign_up', [AuthController::class, 'sign_up']) -> name('sign_up');
Route::get('login', [AuthController::class, 'login']) -> name('login');
Route::get('forget_password', [AuthController::class, 'forget_password']) -> name('forget_password');
Route::get('logout', [AuthController::class, 'logout']) -> name('logout');

// User credentials routes
Route::resource('user', UserController::class);
Route::post('login', [LoginController::class, 'check_credentials']) -> name('check_credentials');

// Incentive
Route::resource('file', FileController::class);

Route::get('brain-box', [SiteController::class, 'brain_box']);
Route::get('favorites', [SiteController::class, 'favorites']);
Route::get('video', [SiteController::class, 'videos']);


