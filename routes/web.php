<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\MeditationController;
use App\Models\Language;

/*
|--------------------------------------------------------------------------
| DASHBOARD (Laravel Breeze compatibility)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| AUTO-REDIRECT TO DEFAULT LANGUAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $defaultLanguage = Language::where('is_default', true)->first();
    
    if ($defaultLanguage) {
        return redirect('/' . $defaultLanguage->code);
    }
    
    // Ако няма default език, пренасочваме към /bg (твърд код)
    return redirect('/bg');
})->name('root');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {
        require __DIR__.'/admin.php';
    });


/*
|--------------------------------------------------------------------------
| FRONTEND Многоезични маршрути
|--------------------------------------------------------------------------
*/

Route::prefix('{lang}')
    ->middleware('setLanguage')
    ->group(function () {

        // Начална страница за даден език
        Route::get('/', function ($lang) {
            $language = Language::where('code', $lang)->first();
            return view('pages.home', compact('language'));
        })->name('home');

        // Медитация
        Route::get('/meditation', [MeditationController::class, 'index'])
            ->name('meditation');

        // Динамични страници от CMS
        Route::get('/{slug}', function ($lang, $slug) {
            $language = Language::where('code', $lang)->first();
            $page = \App\Models\PageTranslation::where('slug', $slug)
                ->where('language_id', $language->id)
                ->firstOrFail();
            return view('pages.dynamic', compact('page', 'language'));
        })->name('page.show');

    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';