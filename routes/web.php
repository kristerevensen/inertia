<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProjectsController;
use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [ProjectsController::class, 'index'])->name('dashboard');
    Route::get('/pages', [PagesController::class, 'index'])->name('pages');



    Route::get('/users', function () {
        return Inertia::render('Users');
    })->name('users');
    Route::get('/users/show', function () {
        return Inertia::render('Users.show');
    })->name('users.show');

    Route::get('/settings/show', function () {
        return Inertia::render('Settings.show');
    })->name('settings.show');

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    })->name('settings');



    Route::get('/seo', function () {
        return Inertia::render('Seo');
    })->name('seo');

    Route::get('/campaigns', function () {
        return Inertia::render('Campaigns');
    })->name('campaigns');

    Route::get('/experimentation', function () {
        return Inertia::render('Experimentation');
    })->name('experimentation');
});
