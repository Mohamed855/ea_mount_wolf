<?php

use App\Http\Controllers\Admin\ActionsController as AdminActionsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\Panel\AdminsController;
use App\Http\Controllers\Admin\Panel\AnnouncementsController;
use App\Http\Controllers\Admin\Panel\EmployeesController;
use App\Http\Controllers\Admin\Panel\FilesController;
use App\Http\Controllers\Admin\Panel\LinesController;
use App\Http\Controllers\Admin\Panel\ManagersController;
use App\Http\Controllers\Admin\Panel\OverviewController;
use App\Http\Controllers\Admin\Panel\SectorsController;
use App\Http\Controllers\Admin\Panel\TitlesController;
use App\Http\Controllers\Admin\Panel\TopicsController;
use App\Http\Controllers\Admin\Panel\VideosController;
use App\Http\Controllers\Admin\Panel\AudiosController;
use App\Http\Controllers\ChooseLoginController;
use App\Http\Controllers\Front\ActionsController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SiteController;
use App\Http\Controllers\Front\UserController;
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

Route::middleware('db.connection')->group(function (){
    // Auth routes
    Route::get('select-user', [ChooseLoginController::class, 'index'])->name('select-user');
    Route::get('employee', [AuthController::class, 'employee_login'])->name('employee.login');
    Route::post('employee', [AuthController::class, 'employee_check_credentials'])->name('employee.check_credentials');
    Route::get('manager', [AuthController::class, 'manager_login'])->name('manager.login');
    Route::post('manager', [AuthController::class, 'manager_check_credentials'])->name('manager.check_credentials');
    Route::get('admin', [AdminAuthController::class, 'admin_login'])->name('admin.login');
    Route::post('admin', [AdminAuthController::class, 'admin_check_credentials'])->name('admin.check_credentials');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    Route::post('logout', [AuthController::class, 'endSession'])->middleware('auth')->name('session.end');
    // Panel
    Route::group(['prefix' => 'panel'], function (){
        // Index
        Route::get('/', [OverviewController::class, 'overview'])->name('panel');
        // Announcements
        Route::resource('announcements', AnnouncementsController::class)->only(['index', 'create', 'store', 'destroy']);
        // Sectors
        Route::resource('sectors', SectorsController::class)->except(['show']);
        // Lines
        Route::resource('lines', LinesController::class)->except(['show']);
        // Titles
        Route::resource('titles', TitlesController::class)->only(['index', 'create', 'store', 'destroy']);
        // Admins
        Route::resource('admins', AdminsController::class)->except(['show']);
        // Managers
        Route::resource('managers', ManagersController::class)->except(['show']);
        // Employees
        Route::resource('employees', EmployeesController::class)->except(['show']);
        // Topics
        Route::resource('ea_topics', TopicsController::class)->except(['show']);
        // Files
        Route::resource('ea_files', FilesController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('panel/ea_files/viewed_by/{id}', [FilesController::class, 'viewed_by'])->name('ea_files.viewed_by');
        // Videos
        Route::resource('videos', VideosController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('panel/videos/viewed_by/{id}', [VideosController::class, 'viewed_by'])->name('ea_videos.viewed_by');
        // Audios
        Route::resource('audios', AudiosController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('panel/audios/viewed_by/{id}', [AudiosController::class, 'viewed_by'])->name('ea_audios.viewed_by');
        // Actions
        Route::post('toggle_active/{id}', [AdminActionsController::class, 'toggle_active'])->name('toggle_active');
        Route::get('password/reset/{id}', [AdminActionsController::class, 'resetPassword'])->name('password.reset');
        Route::post('password/update/{id}', [AdminActionsController::class, 'updatePassword'])->name('password.adminUpdate');
        Route::post('toggle_publish_announcement/{id}', [AdminActionsController::class, 'toggle_publish_announcement'])->name('toggle_publish_announcement');
        Route::post('toggle_publish_topic/{id}', [AdminActionsController::class, 'toggle_publish_topic'])->name('toggle_publish_topic');
        Route::post('toggle_publish_line/{id}', [AdminActionsController::class, 'toggle_publish_line'])->name('toggle_publish_line');
        Route::post('toggle_show_file/{id}', [AdminActionsController::class, 'toggle_show_file'])->name('toggle_show_file');
        Route::post('toggle_show_video/{id}', [AdminActionsController::class, 'toggle_show_video'])->name('toggle_show_video');
        Route::post('toggle_show_audio/{id}', [AdminActionsController::class, 'toggle_show_audio'])->name('toggle_show_audio');
        Route::get('download_report/{table}/{id}', [AdminActionsController::class, 'download_report'])->name('report.download');
    });
    // Profile
    Route::group(['prefix' => 'me'], function (){
        Route::get('profile/{user_name}', [UserController::class, 'profile'])->name('profile');
        Route::get('favorites', [UserController::class, 'favorites'])->name('favorites');
        Route::get('notifications', [UserController::class, 'notifications'])->name('notifications');
        Route::get('change_password', [UserController::class, 'change_password'])->name('password.change');
        Route::put('change_password', [UserController::class, 'update_password'])->name('password.update');
        Route::put('update_profile_picture', [UserController::class, 'update_profile_picture'])->name('profile_picture.update');
        Route::delete('delete_profile_picture', [UserController::class, 'delete_profile_picture'])->name('profile_picture.delete');
    });
    // Site routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('brain_box', [SiteController::class, 'brain_box'])->name('brain_box');
    Route::get('choose_line/{sector_id}', [SiteController::class, 'choose_line'])->name('sector_line.choose');
    Route::get('drive/{sector_id}/line/{line_id}', [SiteController::class, 'drive'])->name('drive');
    Route::get('video/{id}', [SiteController::class, 'video'])->name('video');
    Route::get('audio/{id}', [SiteController::class, 'audio'])->name('audio');
    Route::get('topic/{id}', [SiteController::class, 'topic'])->name('topic');
    Route::get('my/video', [SiteController::class, 'managerVideos'])->name('manager.videos');
    Route::get('add/video', [SiteController::class, 'createVideo'])->name('video.add');
    Route::get('my/audio', [SiteController::class, 'managerAudios'])->name('manager.audios');
    Route::get('add/audio', [SiteController::class, 'createAudio'])->name('audio.add');
    Route::get('my/file', [SiteController::class, 'managerFiles'])->name('manager.files');
    Route::get('add/file', [SiteController::class, 'createFile'])->name('file.add');
    Route::get('credentials/view', [SiteController::class, 'credentials'])->name('credentials.view');
    // Actions
    Route::post('post_comment', [ActionsController::class, 'post_comment'])->name('comment.post');
    Route::post('delete_comment/{id}', [ActionsController::class, 'delete_comment'])->name('comment.delete');
    Route::get('toggle_favorite/{id}', [ActionsController::class, 'toggle_favorite'])->name('favorites.toggle');
    Route::get('toggle_favorite_videos/{id}', [ActionsController::class, 'toggle_favorite_videos'])->name('favorite_videos.toggle');
    Route::get('toggle_favorite_audios/{id}', [ActionsController::class, 'toggle_favorite_audios'])->name('favorite_audios.toggle');
    Route::get('download_file/{id}', [ActionsController::class, 'download_file'])->name('file.download');
    Route::get('view_file/{id}', [ActionsController::class, 'view_file'])->name('file.view');
    Route::get('not_authorized', [ActionsController::class, 'not_authorized'])->name('not_authorized');
    Route::get('credentials/download/{id}', [ActionsController::class, 'downloadCredentials'])->name('credentials.download');
});
