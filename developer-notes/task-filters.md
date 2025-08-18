# Task filters.

This functionality allows the user to filter the tasks by state and/or by priority. To accomplish this I used Laravel Scopes.
A `scope` in Eloquent ORM is a method that allows developers to define reusable query constraints.

**Benefits:**
- Improves query readibilty.
- Reusable filter logic.

## Implementation.
In the `Task` model file I added `scopes`:
```php
public function scopeState($query, $state)
{
    return $query->when(! is_null($state), fn ($q) => $q->where('state', $state));
}

public function scopePriority($query, $priority)
{
    return $query->when(! is_null($priority), fn ($q) => $q->where('priority', $priority));
}
```

Now every time the user wants to filter their tasks, the request include parameters. For this reason I implemented a `Form Request`:
```php
class TaskFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state' => ['nullable', Rule::in([State::TODO, State::IN_PROGRESS, State::COMPLETED])],
            'priority' => ['nullable', Rule::in([Priority::LOW, Priority::MEDIUM, Priority::HIGH])],
        ];
    }
}
```
Here `state`/`priority` must be valid enum values or `null`.

## Usage.
Once the scopes are defined you can use them like this:
```php
public function index(TaskFilterRequest $request)
{
    ...
    $tasks = Task::query()
        ->whereUserId($userId)
        ->state($request->state)
        ->priority($request->priority)
        ->paginate(5);
    ...
}
```
See how now `state` and `priority` act as constraints on the `query`. 
The type of the `request` is `TaskFilterRequest` (explained above).
This example comes from `TaskController`.
