<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\MeditationController;
use App\Models\Language;

/*
|--------------------------------------------------------------------------
| ROOT → Redirect към default language
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $defaultLanguage = Language::where('is_default', true)->first();

    return redirect('/' . ($defaultLanguage->code ?? 'bg'));
})->name('root');


/*
|--------------------------------------------------------------------------
| DASHBOARD (Laravel Breeze redirect към admin)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| LANGUAGE SWITCHER (frontend)
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
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['admin', 'admin.locale'])
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
| FRONTEND (многоезични маршрути)
|--------------------------------------------------------------------------
*/

Route::prefix('{lang}')
    ->middleware('setLanguage')
    ->group(function () {

        /*
        |--------------------------------------
        | Home
        |--------------------------------------
        */
        Route::get('/', function ($lang) {
            $language = Language::where('code', $lang)->firstOrFail();
            return view('pages.home', compact('language'));
        })->name('home');


        /*
        |--------------------------------------
        | Meditation
        |--------------------------------------
        */
        Route::get('/meditation', [MeditationController::class, 'index'])
            ->name('meditation');


        /*
        |--------------------------------------
        | Dynamic Pages
        |--------------------------------------
        */
        Route::get('/{slug}', function ($lang, $slug) {
            $language = Language::where('code', $lang)->firstOrFail();

            $page = \App\Models\PageTranslation::where('slug', $slug)
                ->where('language_id', $language->id)
                ->firstOrFail();

            return view('pages.dynamic', compact('page', 'language'));
        })->name('page.show');

    });