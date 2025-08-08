# Laravel Form Request.

Handles validation for incoming data.

**Benefits:**
- Keeps the controller code clean.
- By the time the request reaches the controller it is already validated.

## What I implemented.
I created two Form Requests:
- **UpdateTaskRequest**
- **CreateTaskRequest**

With the command:
```bash
php artisan make:request [name]
```
The Form Requests are generated in `app/Http/Requests/`

In which file I added the validation rules, inside the `rules()` method.

## Special case: **UpdateTaskRequest**
When updating a task, I needed to allow tha same name if the user did not change it. So, I used:
```php
Rule::unique('tasks')->ignore($this->task->id)
```
