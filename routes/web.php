<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔹 Page d’accueil
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// 🔹 Routes protégées (auth obligatoire)
Route::middleware('auth')->group(function () {

    // 📋 Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 📌 Tasks (CRUD complet)
    Route::resource('tasks', TaskController::class);

    // 🔁 Changer statut rapidement (BONUS)
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.status');

    // 📂 Categories (simple)
    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store', 'destroy']);
});