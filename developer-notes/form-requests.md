# Laravel Form Request.

Handles validation for incoming data.

**Benefits:**
- By the time the request reaches the controller it is already validated.
- Keeps the controller code clean.

## Implementation.
I created two Form Requests:
- **UpdateTaskRequest**
- **CreateTaskRequest**

With the command:
```bash
php artisan make:request [name]
```
The Form Requests are generated in `app/Http/Requests/`

In each file I added the validation rules, inside the `rules()` method.

### Validation rules.
- CreateTaskRequest rules:
```php
public function rules(): array
{
    return [
        'name' => 'required|max:255|unique:tasks',
        'description' => 'required|max:255',
        'state' => ['required', Rule::enum(State::class)],
        'priority' => ['required', Rule::enum(Priority::class)],
    ];
}
```

- UpdateTaskRequest rules:
```php
public function rules(): array
{
    return [
        'name' => [
            'required',
            'max:255',
            Rule::unique('tasks')->ignore($this->task->id),
        ],
        'description' => 'required|max:255',
        'state' => ['required', Rule::enum(State::class)],
        'priority' => ['required', Rule::enum(Priority::class)],
    ];
}
```

### Special case: **UpdateTaskRequest**
As you may see Update Task it is different compared to Create Task. I needed to allow the same name if the user did not change it. So, I used:
```php
Rule::unique('tasks')->ignore($this->task->id)
```

### Authorization.
Both Form Requests have the same `authorize()` method:

```php
public function authorize(): bool
{
    return true;
}
```

This method handles the authorization logic associated with a request.

## Usage in `TaskController`.
See how the request type is different in each case:
```php
public function store(CreateTaskRequest $request)
{
    ...
}
```

```php
public function update(UpdateTaskRequest $request, Task $task)
{
    ...
}
```
