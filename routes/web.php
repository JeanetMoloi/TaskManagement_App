<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskControllerPTJ;
use App\Http\Controllers\CategoryControllerPTJ;
use App\Https\Controllers\DashboardControllerPTJ;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'log.activity'])->group(function () {

    
    Route::get('/dashboard', [DashboardControllerPTJ::class, 'index'])
        ->name('dashboard');

    
    Route::resource('tasks', TaskControllerPTJ::class);

    
    Route::patch('/tasks/{task}/status', [TaskControllerPTJ::class, 'updateStatus'])
        ->name('tasks.update-status');

    
    Route::middleware('role:admin')
        ->resource('categories', CategoryControllerPTJ::class);
});


require __DIR__.'/auth.php';
