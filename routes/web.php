<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\Dashboard\AdminActionsController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Announcements\AnnouncementsController;
use App\Http\Controllers\Admin\Files\FilesController;
use App\Http\Controllers\Admin\Lines\LinesController;
use App\Http\Controllers\Admin\Sectors\SectorsController;
use App\Http\Controllers\Admin\Topics\TopicsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Videos\VideosController;
use App\Http\Controllers\Auth\ConfirmController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ActionsController;

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
Route::post('forget_password', [ForgetPasswordController::class, 'check_credentials']) -> name('reset_password_credentials');
Route::get('confirm_email', [ConfirmController::class, 'confirm_email']) -> name('email.confirm');
Route::get('logout', [LoginController::class, 'logout']) ->middleware('auth') -> name('logout');
// Admin
Route::get('admin', [AdminLoginController::class, 'admin_login']) -> name('admin.login');
Route::post('admin', [AdminLoginController::class, 'admin_check_credentials']) -> name('admin.check_credentials');
Route::get('admin_logout', [AdminLoginController::class, 'logout']) ->middleware('auth') -> name('admin.logout');
// Dashboard
Route::group(['prefix' => 'dashboard'], function (){
    // Index
    Route::get('/', [DashboardController::class, 'dashboard']) -> name('dashboard');
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
    Route::get('downloaded_by/{id}', [FilesController::class, 'downloaded_by'])->name('downloaded_by');
    // Videos
    Route::resource('videos', VideosController::class);
    Route::get('viewed_by/{id}', [VideosController::class, 'viewed_by'])->name('viewed_by');
    // Actions
    Route::post('toggle_active/{id}', [AdminActionsController::class, 'toggle_active'])->name('toggle_active');
    Route::post('toggle_publish_announcement/{id}', [AdminActionsController::class, 'toggle_publish_announcement'])->name('toggle_publish_announcement');
    Route::post('toggle_publish_topic/{id}', [AdminActionsController::class, 'toggle_publish_topic'])->name('toggle_publish_topic');
    Route::post('toggle_show_file/{id}', [AdminActionsController::class, 'toggle_show_file'])->name('toggle_show_file');
    Route::post('toggle_show_video/{id}', [AdminActionsController::class, 'toggle_show_video'])->name('toggle_show_video');
});
// Profile
Route::group(['prefix' => 'me'], function (){
    Route::get('profile/{user_name}', [UserController::class, 'profile']) -> name('profile');
    Route::get('favorites', [UserController::class, 'favorites']) -> name('favorites');
    Route::get('notifications', [UserController::class, 'notifications']) -> name('notifications');
    Route::get('change_password', [UserController::class, 'change_password']) -> name('password.change');
    Route::put('change_password', [UserController::class, 'update_password']) -> name('password.update');
    Route::put('update_profile_picture', [UserController::class, 'update_profile_picture']) -> name('profile_picture.update');
    Route::delete('delete_profile_picture', [UserController::class, 'delete_profile_picture']) -> name('profile_picture.delete');
});
// Site routes
Route::get('brain_box', [SiteController::class, 'brain_box']) -> name('brain_box');
Route::get('choose_line/{sector_id}', [SiteController::class, 'choose_line']) -> name('sector_line.choose');
Route::get('drive/{sector_id}/line/{line_id}', [SiteController::class, 'drive']) -> name('drive');
Route::get('video/{id}', [SiteController::class, 'video']) -> name('video');
Route::get('topic/{id}', [SiteController::class, 'topic']) -> name('topic');
// Actions
Route::post('post_comment', [ActionsController::class, 'post_comment'])->name('comment.post');
Route::post('delete_comment/{id}', [ActionsController::class, 'delete_comment'])->name('comment.delete');
Route::get('toggle_favorite/{id}', [ActionsController::class, 'toggle_favorite'])->name('favorites.toggle');
Route::get('toggle_favorite_videos/{id}', [ActionsController::class, 'toggle_favorite_videos'])->name('favorite_videos.toggle');
Route::get('download_file/{id}', [ActionsController::class, 'download_file'])->name('file.download');
Route::get('not_authorized', [ActionsController::class, 'not_authorized'])->name('not_authorized');
