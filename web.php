<?php

use App\Http\Controllers\Admin\Files\FilesController;
use App\Http\Controllers\Admin\Topics\TopicsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
Route::get('sign_up', [RegisterController::class, 'sign_up']) -> name('sign_up');
Route::post('sign_up', [RegisterController::class, 'register']) -> name('register');
Route::get('login', [LoginController::class, 'login']) -> name('login');
Route::post('login', [LoginController::class, 'check_credentials']) -> name('check_credentials');
Route::get('forget_password', [ForgetPasswordController::class, 'forget_password']) -> name('forget_password');
Route::get('logout', [LoginController::class, 'logout']) ->middleware('auth') -> name('logout');

// User credentials routes
Route::resource('users', UsersController::class);

// Files
Route::resource('files', FilesController::class);

// Topics
Route::resource('topics', TopicsController::class);

Route::get('favorites', [SiteController::class, 'favorites']) -> name('favorites');
Route::get('video', [SiteController::class, 'videos']);

Route::get('not_authorized', [SiteController::class, 'not_authorized'])->name('not_authorized');
Route::post('post_comment', [SiteController::class, 'post_comment'])->name('post_comment');

