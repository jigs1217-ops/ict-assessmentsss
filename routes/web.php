<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    /**
     * Profile Routes
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Assessment Routes
     */
    // Static routes first
    Route::get('/assessment', [AssessmentController::class, 'assessment'])->name('assessment.index');
    Route::get('/assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');

    // Parameterized routes after static
    Route::get('/assessment/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessment.edit');
    Route::put('/assessment/{assessment}', [AssessmentController::class, 'update'])->name('assessment.update');

    // AJAX modals for view and delete
    Route::get('/assessment/{assessment}/viewbt', [AssessmentController::class, 'viewbt'])->name('assessment.viewbt');
    Route::delete('/assessment/{assessment}', [AssessmentController::class, 'destroy'])->name('assessment.destroy');
    // Store route (POST)
    Route::post('/assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
});

require __DIR__ . '/auth.php';
