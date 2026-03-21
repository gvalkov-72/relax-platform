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
| LANGUAGE SWITCHER (за фронтенд)
|--------------------------------------------------------------------------
*/

Route::get('/language/{lang}', function ($lang) {
    if (!in_array($lang, ['bg', 'en'])) {
        abort(404);
    }
    session(['locale' => $lang]);
    return redirect()->back();
})->name('language.switch');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES – добавено middleware admin.locale
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['admin', 'admin.locale']) // <- важно: добавяме admin.locale
    ->group(function () {
        require __DIR__.'/admin.php';
    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| FRONTEND Многоезични маршрути
|--------------------------------------------------------------------------
*/

Route::prefix('{lang}')
    ->middleware('setLanguage')
    ->group(function () {

        Route::get('/', function ($lang) {
            $language = Language::where('code', $lang)->first();
            return view('pages.home', compact('language'));
        })->name('home');

        Route::get('/meditation', [MeditationController::class, 'index'])
            ->name('meditation');

        Route::get('/{slug}', function ($lang, $slug) {
            $language = Language::where('code', $lang)->first();
            $page = \App\Models\PageTranslation::where('slug', $slug)
                ->where('language_id', $language->id)
                ->firstOrFail();
            return view('pages.dynamic', compact('page', 'language'));
        })->name('page.show');

    });