<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

    Route::get('/projects', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/tasks', [TaskController::class, 'create'])->name('task.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::get('/tasks/{id}/start', [TaskController::class, 'start'])->name('task.start');
    Route::get('/tasks/{id}/stop', [TaskController::class, 'stop'])->name('task.stop');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    
    Route::get('/logs', [LogController::class, 'show'])->name('logs.show');
    Route::get('/logs/exportCsv', [LogController::class, 'exportCsv'])->name('logs.exportCsv');
});


require __DIR__.'/auth.php';
