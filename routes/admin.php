<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\MeditationController;
use App\Http\Controllers\Admin\AudioFileController;
use App\Http\Controllers\Admin\BrainwavePresetController;
use App\Http\Controllers\Admin\MeditationBuilderController;

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
*/
Route::resource('users', UserController::class)
    ->names('admin.users');


/*
|--------------------------------------------------------------------------
| ROLES
|--------------------------------------------------------------------------
*/
Route::resource('roles', RoleController::class)
    ->names('admin.roles');


/*
|--------------------------------------------------------------------------
| PERMISSIONS
|--------------------------------------------------------------------------
*/
Route::resource('permissions', PermissionController::class)
    ->names('admin.permissions');


/*
|--------------------------------------------------------------------------
| MEDITATIONS
|--------------------------------------------------------------------------
*/
Route::resource('meditations', MeditationController::class)
    ->names('admin.meditations');

/*
|--------------------------------------------------------------------------
| AUDIO
|--------------------------------------------------------------------------
*/
Route::resource('audio', AudioFileController::class)
    ->parameters(['audio' => 'audio'])
    ->names('admin.audio');

/*
|--------------------------------------------------------------------------
| BRAINWAVES
|--------------------------------------------------------------------------
*/
Route::resource('brainwaves', BrainwavePresetController::class)
    ->names('admin.brainwaves');

/*
|--------------------------------------------------------------------------
| MEDITATION BUILDER
|--------------------------------------------------------------------------
*/

Route::get(
    'meditations/{id}/builder',
    [MeditationBuilderController::class, 'index']
)->name('admin.meditation.builder');

Route::get(
    'meditations/{id}/builder/create',
    [MeditationBuilderController::class, 'create']
)->name('admin.meditation.builder.create');

Route::post(
    'meditation-builder/store',
    [MeditationBuilderController::class, 'store']
)->name('admin.meditation.builder.store');

Route::delete(
    'meditation-builder/{id}',
    [MeditationBuilderController::class, 'destroy']
)->name('admin.meditation.builder.destroy');
    