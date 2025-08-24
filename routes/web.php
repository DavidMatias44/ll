<?php

use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('create', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('update/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('delete/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');

        Route::get('import-form', [TaskImportController::class, 'showImportForm'])->name('tasks.import.form');
        Route::post('import-csv', [TaskImportController::class, 'importCSV'])->name('tasks.import.csv');

        Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
    });

    Route::prefix('pomodoro')->group(function () {
        Route::get('/', function () {
            return view('pomodoro');
        })->name('pomodoro.timer');
    });
});

require __DIR__.'/auth.php';
