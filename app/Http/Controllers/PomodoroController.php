<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;

class PomodoroController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $tasks = Task::query()->whereUserId($userId)->get();

        return view('pomodoro')->with('tasks', $tasks);
    }
}
