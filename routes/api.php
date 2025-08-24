<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('/users/{user}/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('{task}', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});
