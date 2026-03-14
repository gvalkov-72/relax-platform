<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\MeditationController;
use App\Http\Controllers\Admin\AudioFileController;
use App\Http\Controllers\Admin\BrainwavePresetController;
use App\Http\Controllers\Admin\MeditationBuilderController;
use App\Http\Controllers\RagChatController;

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
| LANGUAGES
|--------------------------------------------------------------------------
*/
Route::resource('languages', LanguageController::class)
    ->names('admin.languages');

/*
|--------------------------------------------------------------------------
| PAGES
|--------------------------------------------------------------------------
*/
Route::resource('pages', PageController::class)
    ->names('admin.pages');

/*
|--------------------------------------------------------------------------
| SECTIONS
|--------------------------------------------------------------------------
*/
Route::resource('sections', SectionController::class)
    ->names('admin.sections');

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

Route::post(
    'meditation-builder/update-position',
    [MeditationBuilderController::class, 'updatePosition']
)->name('admin.meditation.builder.updatePosition');

/*
|--------------------------------------------------------------------------
| AI ASSISTANT
|--------------------------------------------------------------------------
*/

Route::get('/ai-assistant', [RagChatController::class, 'index'])->name('admin.ai.assistant');
Route::post('/ai/ask', [RagChatController::class, 'ask'])->name('ai.ask');
Route::post('/ai/generate-page', [RagChatController::class, 'generatePage'])->name('ai.generate.page');
Route::post('/ai/generate-section', [RagChatController::class, 'generateSection'])->name('ai.generate.section');
Route::post('/ai/reindex', [RagChatController::class, 'reindex'])->name('ai.reindex');
    