# API-Rest

Implementing this feature was a great opportunity to understand why an API is necessary in addition to views and other components:
- It allow external clients of frontend applications to interact with the system.
- It enable future third-party integrations.

Although the impact of this project is limited, it is being developed for educational purposes. And the knowledge gained will be valuable for future (with more impact) projects.

## Implementation.
- To start creating the API endpoints, I ran the command:
```bash
php artisan install:api
```
The file `routes/api.php` was created.

- To keep api.php clean I decided to create a new `Controller`. Stored in the directory: `app/Http/Api`.
```bash
php artisan make:controller Api/TaskController --api
```
The `--api` options generated all the methods needed for an API. In other words the methods to return views are not included.

- I needed a new `Resource` class.
```bash
php artisan make:resource TaskResource
```
In Laravel, a `Resource` is a class that transform an Eloquent Model into a structured JSON format.

### Routes defined in `routes/api.php`:
```php
Route::prefix('/users/{user}/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('{task}', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});
```
The prefix ensures that every request is associated with a specific user.

### Methods defined in `app/Http/Api/TaskController.php`:
```php
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
    $task = Task::create($request->all());

    return response()->json($task, Response::HTTP_CREATED);
}

public function show(User $user, Task $task)
{
    return new TaskResource(Task::findOrFail($task->id));
}

public function update(UpdateTaskRequest $request, User $user, Task $task)
{
    $task->update($request->all());

    return response()->json($task, Response::HTTP_OK);
}

public function destroy(User $user, Task $task)
{
    $task->delete();

    return response()->json(Response::HTTP_OK);
}
```
The `Form Requests` used in this file are described in detail in: `developer-notes/form-requests.md` (`UpdateTaskRequest` & `CreateTaskRequest`) and `developer-notes/task-filters.md` (`TaskFilterRequest`).

### `TaskResource` file:
```php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'state' => $this->state->label(),
        'priority' => $this->priority->label(),
        'user_id' => $this->user_id,
    ];
}
```
All fields returned by the `toArray()` method will be included in the JSON representation of a task or a collection of tasks.