<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// routes for authentication

Auth::routes();

// routes for admins
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin/dashboard');
    Route::get('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('admin/articles');
    Route::get('/create-article', [App\Http\Controllers\Admin\ArticleController::class, 'createView'])->name('admin/create-article-view');
    Route::post('/create-article', [App\Http\Controllers\Admin\ArticleController::class, 'create'])->name('admin/create-article');
    Route::post('/delete-article', [App\Http\Controllers\Admin\ArticleController::class, 'delete'])->name('admin/delete-article');

    Route::get('/manage-admins', [App\Http\Controllers\Admin\UserController::class, 'manageAdmins'])->name('admin/manage-admins');
    Route::get('/manage-journalists', [App\Http\Controllers\Admin\UserController::class, 'manageJournalists'])->name('admin/manage-journalists');
    Route::get('/manage-users', [App\Http\Controllers\Admin\UserController::class, 'manageUsers'])->name('admin/manage-users');
    Route::post('/create-admin', [App\Http\Controllers\Admin\UserController::class, 'createAdmin'])->name('admin/create-admin');
    Route::post('/create-journalist', [App\Http\Controllers\Admin\UserController::class, 'createJournalist'])->name('admin/create-journalist');
    Route::post('/create-user', [App\Http\Controllers\Admin\UserController::class, 'createUser'])->name('admin/create-user');
    Route::post('/lock-user', [App\Http\Controllers\Admin\UserController::class, 'lockUser'])->name('admin/lock-user');
    Route::post('/unlock-user', [App\Http\Controllers\Admin\UserController::class, 'unlockUser'])->name('admin/unlock-user');
});

// routes for journalists
Route::prefix('journalist')->middleware('auth')->group(function() {

});

Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
Route::get('/invitation/{token}', [App\Http\Controllers\Auth\InviteController::class, 'inviteView'])->name('invitation');
Route::post('/accept-invitation', [App\Http\Controllers\Auth\InviteController::class, 'acceptInvitation'])->name('accept-invitation');
