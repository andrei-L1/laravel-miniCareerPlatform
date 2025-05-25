<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobSeekerController;

// Authentication Routes
Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::get('/login', [AuthenticationController::class, 'index'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('logout');

Route::resource('auth', AuthenticationController::class)->only([
    'index',    
    'create',   
    'store',    
]);

Route::post('/auth/login', [AuthenticationController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [AuthenticationController::class, 'destroy'])->name('auth.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Job Seeker Routes (for both students and professionals)
    Route::prefix('job-seeker')->name('job_seeker.')->group(function () {
        Route::get('/opportunities', [JobSeekerController::class, 'opportunities'])->name('opportunities');
        Route::get('/resources', [JobSeekerController::class, 'resources'])->name('resources');
        Route::get('/saved-jobs', [JobSeekerController::class, 'savedJobs'])->name('saved_jobs');
        Route::get('/applications', [JobSeekerController::class, 'applications'])->name('applications');
        Route::get('/profile', [JobSeekerController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [JobSeekerController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [JobSeekerController::class, 'update'])->name('profile.update');
    });
       
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{job}', [AdminController::class, 'showJob'])->name('jobs.show');
    Route::patch('/jobs/{job}/status', [AdminController::class, 'updateJobStatus'])->name('jobs.update-status');
    Route::delete('/jobs/{job}', [AdminController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/resources', [AdminController::class, 'resources'])->name('resources');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Employer Routes
Route::middleware(['auth'])->prefix('employer')->name('employer.')->group(function () {
    Route::resource('jobs', EmployerController::class);
});



