<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

// 🔹 Splash
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔹 Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Tasks CRUD complet
    Route::get('/tasks',              [TaskController::class, 'index'])  ->name('tasks.index');
    Route::get('/tasks/create',       [TaskController::class, 'create']) ->name('tasks.create');
    Route::post('/tasks',             [TaskController::class, 'store'])  ->name('tasks.store');
    Route::get('/tasks/{task}/edit',  [TaskController::class, 'edit'])   ->name('tasks.edit');
    Route::put('/tasks/{task}',       [TaskController::class, 'update']) ->name('tasks.update');
    Route::delete('/tasks/{task}',    [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    // ... reste des routes
});

});

require __DIR__.'/auth.php';