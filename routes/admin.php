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
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\RagChatController;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $usersCount = User::count();

    $onlineThreshold = now()->subMinutes(2)->timestamp;
    $onlineUserIds = DB::table('sessions')
        ->where('last_activity', '>=', $onlineThreshold)
        ->whereNotNull('user_id')
        ->distinct()
        ->pluck('user_id');

    $onlineUsersCount = $onlineUserIds->count();
    $onlineUsers = User::whereIn('id', $onlineUserIds)
        ->select('id', 'name', 'email')
        ->get();

    return view('admin.dashboard', compact('usersCount', 'onlineUsersCount', 'onlineUsers'));
})->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| ONLINE USERS API (за AJAX polling)
|--------------------------------------------------------------------------
*/
Route::get('/online-users', function () {
    $onlineThreshold = now()->subMinutes(2)->timestamp;
    $onlineUserIds = DB::table('sessions')
        ->where('last_activity', '>=', $onlineThreshold)
        ->whereNotNull('user_id')
        ->distinct()
        ->pluck('user_id');

    $onlineUsersCount = $onlineUserIds->count();
    $onlineUsers = User::whereIn('id', $onlineUserIds)
        ->select('id', 'name', 'email')
        ->get();

    return response()->json([
        'count' => $onlineUsersCount,
        'users' => $onlineUsers,
    ]);
})->name('admin.online-users')->middleware('auth');


/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
*/
Route::resource('users', UserController::class)
    ->names('admin.users')
    ->middleware('can:manage users');

/*
|--------------------------------------------------------------------------
| ROLES
|--------------------------------------------------------------------------
*/
Route::resource('roles', RoleController::class)
    ->names('admin.roles')
    ->middleware('can:manage roles');

/*
|--------------------------------------------------------------------------
| PERMISSIONS
|--------------------------------------------------------------------------
*/
Route::resource('permissions', PermissionController::class)
    ->names('admin.permissions')
    ->middleware('can:manage permissions');

/*
|--------------------------------------------------------------------------
| LANGUAGES
|--------------------------------------------------------------------------
*/
Route::resource('languages', LanguageController::class)
    ->names('admin.languages')
    ->middleware('can:manage languages');

/*
|--------------------------------------------------------------------------
| PAGES
|--------------------------------------------------------------------------
*/
Route::resource('pages', PageController::class)
    ->names('admin.pages')
    ->middleware('can:manage pages');

/*
|--------------------------------------------------------------------------
| SECTIONS
|--------------------------------------------------------------------------
*/
Route::resource('sections', SectionController::class)
    ->names('admin.sections')
    ->middleware('can:manage sections');

/*
|--------------------------------------------------------------------------
| MEDITATIONS
|--------------------------------------------------------------------------
*/
Route::resource('meditations', MeditationController::class)
    ->names('admin.meditations')
    ->middleware('can:manage meditations');

/*
|--------------------------------------------------------------------------
| AUDIO
|--------------------------------------------------------------------------
*/
Route::resource('audio', AudioFileController::class)
    ->parameters(['audio' => 'audio'])
    ->names('admin.audio')
    ->middleware('can:manage audio');

/*
|--------------------------------------------------------------------------
| BRAINWAVES
|--------------------------------------------------------------------------
*/
Route::resource('brainwaves', BrainwavePresetController::class)
    ->names('admin.brainwaves')
    ->middleware('can:manage brainwaves');

/*
|--------------------------------------------------------------------------
| MEDITATION BUILDER
|--------------------------------------------------------------------------
*/
Route::get('meditations/{id}/builder', [MeditationBuilderController::class, 'index'])
    ->name('admin.meditation.builder')
    ->middleware('can:manage meditations');

Route::get('meditations/{id}/builder/create', [MeditationBuilderController::class, 'create'])
    ->name('admin.meditation.builder.create')
    ->middleware('can:manage meditations');

Route::post('meditation-builder/store', [MeditationBuilderController::class, 'store'])
    ->name('admin.meditation.builder.store')
    ->middleware('can:manage meditations');

Route::delete('meditation-builder/{id}', [MeditationBuilderController::class, 'destroy'])
    ->name('admin.meditation.builder.destroy')
    ->middleware('can:manage meditations');

Route::post('meditation-builder/update-position', [MeditationBuilderController::class, 'updatePosition'])
    ->name('admin.meditation.builder.updatePosition')
    ->middleware('can:manage meditations');

/*
|--------------------------------------------------------------------------
| CONTENTS (Идеи и документи)
|--------------------------------------------------------------------------
*/
Route::resource('contents', ContentController::class)
    ->names('admin.contents')
    ->middleware('can:manage contents');

Route::delete('contents/attachments/{attachment}', [ContentController::class, 'deleteAttachment'])
    ->name('admin.contents.deleteAttachment')
    ->middleware('can:manage contents');

Route::get('contents/{content}', [ContentController::class, 'show'])
    ->name('admin.contents.show')
    ->middleware('can:manage contents');

Route::get('contents/download/{attachment}', [ContentController::class, 'download'])
    ->name('admin.contents.download')
    ->middleware('can:manage contents');

/*
|--------------------------------------------------------------------------
| TAGS (Тагове)
|--------------------------------------------------------------------------
*/
Route::resource('tags', TagController::class)
    ->names('admin.tags')
    ->middleware('can:manage tags');

/*
|--------------------------------------------------------------------------
| ADMIN LANGUAGE SWITCHER
|--------------------------------------------------------------------------
*/
Route::get('/language/{lang}', function ($lang) {
    if (!in_array($lang, ['bg', 'en'])) {
        abort(404);
    }
    session(['admin_locale' => $lang]);
    return redirect()->back();
})->name('admin.language.switch');

/*
|--------------------------------------------------------------------------
| AI ASSISTANT
|--------------------------------------------------------------------------
*/
Route::get('/ai-assistant', [RagChatController::class, 'index'])
    ->name('admin.ai.assistant')
    ->middleware('can:manage ai');

Route::post('/ai/ask', [RagChatController::class, 'ask'])
    ->name('ai.ask')
    ->middleware('can:manage ai');

Route::post('/ai/generate-page', [RagChatController::class, 'generatePage'])
    ->name('ai.generate.page')
    ->middleware('can:manage ai');

Route::post('/ai/generate-section', [RagChatController::class, 'generateSection'])
    ->name('ai.generate.section')
    ->middleware('can:manage ai');

Route::post('/ai/reindex', [RagChatController::class, 'reindex'])
    ->name('ai.reindex')
    ->middleware('can:manage ai');