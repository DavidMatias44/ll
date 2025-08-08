# Laravel Policy.

Handles the authorization logic for a specific resource. It determines whether a user is allowed to perform a given action.

## What I implemented:
I created a  **TaskPolicy** to control access to `Task` resources.

Using the command:
```bash
php artisan make:policy TaskPolicy --model=Task
```

This generates a file in `app/Policies/` with several methods, such as: `view`, `create`, `update`.

### Registering the Policy.

I registered it manually adding:
```php
Gate::policy(Task::class, TaskPolicy::class);
```
in the **boot()** method of **AppServiceProvider**.

### Using the Policy.
In a controller (or anywhere authorization is needed) you can add:
```php
Gate::authorize('methodName', $task);
```
