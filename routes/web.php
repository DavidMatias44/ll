<?php

use App\Http\Controllers\ProfileController;
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

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('create', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('update/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('delete/{id}', [TaskController::class, 'destroy'])->name('tasks.delete');

        Route::get('/{id}', [TaskController::class, 'show'])->name('tasks.show');
    });
});

require __DIR__.'/auth.php';
