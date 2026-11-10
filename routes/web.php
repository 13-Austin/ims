<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DemographicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SkController;
use App\Http\Controllers\KatipunanNgKabataanController;
use App\Http\Controllers\SkProjectController;
use App\Http\Controllers\SkBudgetController;
use App\Http\Controllers\BlotterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Direktang i-redirect ang root URL papuntang login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected Routes requiring Authentication
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Route (Para sa lahat)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // PUNONG BARANGAY & CERTIFICATE APPROVALS ROUTES
    // ==========================================
    Route::middleware([\App\Http\Middleware\PbMiddleware::class])->group(function () {
        Route::resource('documents', DocumentController::class);
        Route::patch('/documents/{document}/status', [DocumentController::class, 'updateStatus'])->name('documents.status');
        
        // Demographic Analytics
        Route::get('/demographics', [DemographicController::class, 'index'])->name('demographics.index');
    });

    // ==========================================
    // ADMIN-ONLY ROUTES (Protected by AdminMiddleware)
    // ==========================================
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        
        // Resident Profiling & Information Management Module
        Route::resource('residents', ResidentController::class);

        // User Management Module
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // Project Tracking & Budget Management Module
        Route::resource('projects', ProjectController::class);

        // Blotter / Katarungang Pambarangay Module
        Route::resource('blotter', BlotterController::class);

        // SK Operations Routes Group
        Route::prefix('sk')->name('sk.')->group(function () {
            // SK Dashboard
            Route::get('/dashboard', [SkController::class, 'index'])->name('dashboard');

            // Katipunan ng Kabataan Registry
            Route::get('/katipunan', [KatipunanNgKabataanController::class, 'index'])->name('katipunan');
            Route::post('/katipunan', [KatipunanNgKabataanController::class, 'store'])->name('katipunan.store');

            // SK Projects
            Route::get('/projects', [SkProjectController::class, 'index'])->name('projects');
            Route::post('/projects', [SkProjectController::class, 'store'])->name('projects.store');

            // SK Budget (10% Fund)
            Route::get('/budget', [SkBudgetController::class, 'index'])->name('budget');
            Route::post('/budget', [SkBudgetController::class, 'store'])->name('budget.store');
        });
    });
});

require __DIR__.'/auth.php';