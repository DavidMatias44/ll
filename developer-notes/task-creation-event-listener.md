# Task creation event - listener.

The implementation of an **event-listener** pattern is a good way to separate responsabilities, controller's only responsability is to create a new task, subsequent actions (logging, notifications, etc.) is delegated to events and their listeners.

**Benefits**:
- New listeners can be attached to this event such as: notification via email.
- Brings **scalability** if the system grows, events can be **queued**.

Recent versions of Laravel offers events **"auto-discovery"**, in other words the developer does not have to manually register the listener in `EventServiceProvider`.

## Implementation.

### Event dispatching.
When a task is created by a user the `store()` method in `app/Http/Controllers/TaskController.php` generates a new event.
```php
public function store(CreateTaskRequest $request)
{
    ...
    event(new TaskCreated($task));
    ...
}
```

### Event definition.
The event `TaskCreated` is stored in `app/Events`.
This file was created using the command:
```bash
php artisan make:event TaskCreated
```

As you may see above the new instance of `TaskCreated` receives a Task model as a parameter:
```php
class TaskCreated
{
    ...

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    ...
}
```

### Listener binding.
This event has a listener: `LogTaskCreation`, stored in `app/Listeners`. Created using:
```bash
php artisan make:listener LogTaskCreation --event=TaskCreated
```
The `--event` option associates the listener with the specified event.



The `handle()` method is executed every time the `TaskCreated` event is generated. 
```php
class LogTaskCreation
{
    ...

    public function handle(TaskCreated $event): void
    {
        $taskId = $event->task->id;
        Log::channel('taskCreation')->info("Task creation: $taskId");
    }
}
```

### Custom logging channel.
I am using this log file: `storage/logs/TaskCreation.log` to store every task creation.
In order to be able to do this I modified the `config/logging.php` file, I added a new channel `'taskCreation'`:
```php
return [

    ...

    'channels' => [

        ...

        'taskCreation' => [
            'driver' => 'single',
            'path' => storage_path('logs/TaskCreation.log'),
            'level' => 'info',
        ],

    ],

];
```

### Inside `TaskCreation.log`.
This is an example:
```
[2025-08-22 18:47:21] local.INFO: Task creation: 135  
```
