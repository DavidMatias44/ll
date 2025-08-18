<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\TaskFilterRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(TaskFilterRequest $request, User $user)
    {   
        return TaskResource::collection(
            Task::query()
                ->whereUserId($user->id)
                ->state($request->state)
                ->priority($request->priority)
                ->paginate(5));
    }

    public function store(CreateTaskRequest $request, User $user)
    {
        $request['user_id'] = $user->id;
        Task::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => Task::all()->last(),
            'code' => 201,
        ]);
    }

    public function show(User $user, Task $task)
    {
        return new TaskResource(Task::findOrFail($task->id));
    }

    public function update(UpdateTaskRequest $request, User $user, Task $task)
    {
        $task->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $task,
            'code' => 200,
        ]);
    }

    public function destroy(User $user, Task $task)
    {
        $task->delete();

        return response()->json([
            'status' => 'success',
            'code' => 204
        ]);
    }
}
