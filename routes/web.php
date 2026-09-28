<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\IdentityController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/cv/{type}', [PortfolioController::class, 'downloadCv'])->name('cv.download');

/*
|--------------------------------------------------------------------------
| Admin Routes: logged in AND matching ADMIN_EMAIL from .env
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/identity', [IdentityController::class, 'edit'])->name('identity.edit');
    Route::put('/identity', [IdentityController::class, 'update'])->name('identity.update');

    Route::resource('education', EducationController::class)->except(['show']);
    Route::resource('experience', ExperienceController::class)->except(['show']);
    Route::resource('skills', SkillController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);
});

// Breeze redirects here after login; forward to our admin dashboard.
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', EnsureIsAdmin::class])->name('dashboard');

Route::middleware(['auth', EnsureIsAdmin::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
