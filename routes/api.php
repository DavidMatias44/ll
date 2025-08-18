<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::prefix('/users/{user}/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('{task}', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});
