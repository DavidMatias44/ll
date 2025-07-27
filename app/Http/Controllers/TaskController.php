<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'priority' => 'required',
            'state' => 'required'
        ]);
        $validated['user_id'] = Auth::id();

        Task::create($validated);
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

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
            'priority' => 'required',
            'state' => 'required'
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

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
