<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Auth;

class TaskController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $tasks = Task::whereUserId($userId)->get();
        return view('tasks.index')->with('tasks', $tasks);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(CreateTaskRequest $request)
    {
        $request['user_id'] = Auth::id();
        Task::create($request->all());

        return redirect(route('tasks.index'));
    }

    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show')->with('task', $task);
    }

    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit')->with('task', $task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());

        return redirect(route('tasks.index'));
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        if ($task) {
            $task->delete();
        }
        return redirect(route('tasks.index'));
    }
}
