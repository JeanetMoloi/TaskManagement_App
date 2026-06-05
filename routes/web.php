<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskControllerPTJ;
use App\Http\Controllers\CategoryControllerPTJ;
use App\Http\Controllers\DashboardControllerPTJ;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Task Management App (PTJ)
|--------------------------------------------------------------------------
*/

// ── Public routes ──────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Authenticated routes ────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — role-aware (admin/team_member/guest)
    Route::get('/dashboard', [DashboardControllerPTJ::class, 'index'])
        ->name('dashboard');

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',     [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/',   [ProfileController::class, 'update'])->name('update');
        Route::delete('/',  [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// ── Task & Category routes (auth + activity logging) ───────────────────
Route::middleware(['auth', 'log.activity'])->group(function () {

    // Task resource routes (index, create, store, show, edit, update, destroy)
    Route::resource('tasks', TaskControllerPTJ::class);

    // Quick status update route
    Route::patch('/tasks/{task}/status', [TaskControllerPTJ::class, 'updateStatus'])
        ->name('tasks.update-status');

    // Category routes — admin only
    Route::middleware('role:admin')
        ->resource('categories', CategoryControllerPTJ::class);
});

require __DIR__.'/auth.php';