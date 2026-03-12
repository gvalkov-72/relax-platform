<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\MeditationController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/meditation', [MeditationController::class, 'index'])
    ->name('meditation');


/*
|--------------------------------------------------------------------------
| DASHBOARD (Laravel Breeze compatibility)
|--------------------------------------------------------------------------
|
| Breeze очаква route('dashboard') след login.
| Ние го пренасочваме към admin dashboard.
|
*/

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| Всички admin routes са изнесени в routes/admin.php
| и използват admin middleware group.
|
*/

Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        require __DIR__.'/admin.php';

    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';