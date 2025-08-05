<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\TaskFilterRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use Auth;

class TaskController extends Controller
{
    public function index(TaskFilterRequest $request)
    {
        Gate::authorize('viewAny', Task::class);

        $userId = Auth::id();
        $tasks = Task::query()
            ->whereUserId($userId)
            ->state($request->state)
            ->priority($request->priority)
            ->paginate(5);

        return view('tasks.index')->with('tasks', $tasks);
    }

    public function create()
    {
        Gate::authorize('create', Task::class);

        return view('tasks.create');
    }

    public function store(CreateTaskRequest $request)
    {
        $request['user_id'] = Auth::id();
        Task::create($request->all());

        return redirect()->route('tasks.index')->withSuccess('Task was created successfully.');
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return view('tasks.show')->with('task', $task);
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        return view('tasks.edit')->with('task', $task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());
        return redirect()->route('tasks.index')->withSuccess('Task was edited successfully.');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect(route('tasks.index'));
    }
}
