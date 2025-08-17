# Laravel Policy.

Handles the authorization logic for a specific resource. It determines whether a user is allowed to perform a given action.

## Implementation:
I created a  **TaskPolicy** to control access to `Task` resources.

Using the command:
```bash
php artisan make:policy TaskPolicy --model=Task
```

This generates a file in `app/Policies/` with several methods, such as: `view`, `create`, `update`.

The following code is for the `update()` method:

```php
public function update(User $user, Task $task): bool
{
    return $user->id == $task->user_id;
}
```

A user can only update their own tasks.

### Registering the Policy.

I registered it manually adding the `Gate::policy` into the `boot()` method in `AppServiceProvider` file.
```php
public function boot(): void
{
    Gate::policy(Task::class, TaskPolicy::class);
    ...
}
```

## Using the Policy.
`update()` method in the `TaskController`:
```php
public function update(UpdateTaskRequest $request, Task $task)
{
    Gate::authorize('update', $task);
    ...
}
```
