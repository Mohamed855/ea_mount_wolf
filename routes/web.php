<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Files\FavoritesController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\LinesController;
use App\Http\Controllers\Admin\SectorsController;
use App\Http\Controllers\Admin\TopicsController;
use App\Http\Controllers\Admin\UsersController;
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

// Dashboard
Route::get('dashboard', [DashboardController::class, 'dashboard']) -> name('dashboard');

// Announcements
Route::resource('announcements', AnnouncementsController::class);

// Sectors
Route::resource('sectors', SectorsController::class);

// Lines
Route::resource('lines', LinesController::class);

// Users
Route::resource('users', UsersController::class);

// Topics
Route::resource('ea_topics', TopicsController::class);

// Files
Route::resource('ea_files', FilesController::class);

// Site routes
Route::get('favorites', [SiteController::class, 'favorites']) -> name('favorites');
Route::get('drive/{sector_id}/line/{line_id}', [SiteController::class, 'drive']) -> name('drive');
Route::get('file/{id}', [SiteController::class, 'file']) -> name('file');
Route::get('brain_box', [SiteController::class, 'brain_box']) -> name('brain_box');
Route::get('topic/{id}', [SiteController::class, 'topic']) -> name('topic');


// Actions
Route::post('post_comment', [ActionsController::class, 'post_comment'])->name('post_comment');
Route::post('delete_comment/{id}', [ActionsController::class, 'delete_comment'])->name('delete_comment');
Route::post('toggle_active/{id}', [ActionsController::class, 'toggle_active'])->name('toggle_active');
Route::post('toggle_publish/{id}', [ActionsController::class, 'toggle_publish'])->name('toggle_publish');
Route::post('toggle_show/{id}', [ActionsController::class, 'toggle_show'])->name('toggle_show');
Route::get('not_authorized', [ActionsController::class, 'not_authorized'])->name('not_authorized');
