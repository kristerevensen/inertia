<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\LesbarhetsController;
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
    Route::post('/project/store', [ProjectsController::class, 'store']);
    Route::get('/project/{url_code}/edit', [ProjectsController::class, 'edit']);
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/project/{url_code}/delete', [ProjectsController::class, 'delete'])->name('project.delete');


     // Subpages of /pages
     Route::get('/pages', [PagesController::class, 'index'])->name('pages');
     Route::get('/pages/overview', [PagesController::class, 'overview'])->name('pages.overview');
     Route::get('/pages/technical', [PagesController::class, 'technical'])->name('pages.technical');
     Route::get('/pages/content', [PagesController::class, 'content'])->name('pages.content');
     Route::get('/pages/ranking', [PagesController::class, 'ranking'])->name('pages.ranking');
     Route::get('/page/view/{url_code}', [PagesController::class, 'show'])->name('page.view');
     Route::get('/page/edit/{url_code}', [PagesController::class, 'edit'])->name('page.edit');
     Route::get('/page/delete/{url_code}', [PagesController::class, 'delete'])->name('page.delete');

     Route::get('/keywords', [KeywordController::class, 'index'])->name('keywords');

     Route::get('campaigns', [CampaignController::class, 'index'])->name('campaigns');


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

    Route::get('/lesbarhet', [LesbarhetsController::class, 'index'])->name('lesbarhet');
    Route::post('/lesbarhet', [LesbarhetsController::class, 'beregn'])->name('lesbarhet.beregn');







    Route::get('/campaigns', function () {
        return Inertia::render('Campaigns');
    })->name('campaigns');

    Route::get('/experimentation', function () {
        return Inertia::render('Experimentation');
    })->name('experimentation');
});
