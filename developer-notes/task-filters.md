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

### Blade views.
To filter tasks I implemented a form in `index.blade.php` view. This form contains `select` elements where all possible values for `State` and `Priority` are listed for the user to choose. 

Using **Alpine.js** I enable the `'Filter'` button by detecting when a change has occurred in at least one of the `select` elements.
- I defined a boolean variable to archieve this.
```php
<form x-data="{ filterSelected : false }" ... >
    ...
</form>
```
- I added the `@change` directive to update the variable's value to true.
```php
<select @change="filterSelected = true" ...>
    ...
</select>
```

Laravel provides the `request()` helper, which allows you to obtain certain values from the current request. In this case, `'state'` and `'priority'` are used. If no filters are applied then their value are `null` otherwise they have the corresponding enum values.

I used this `request()` helper to keep the selected values chosen by the user once the filters are applied (send the request and get a response).
```php
<select ...>
    ...
    @foreach (App\Enums\Tasks\State::cases() as $state)
        <option value="{{ $state->value }}" {{ ("$state->value" === request('state')) ? 'selected' : '' }}>{{ $state->label() }}</option>
    @endforeach
</select>
```

There is an `@if` directive that compares the value of `'state'` and `'priority'` with `null` to enable/disable the `Clear filters` button.
```php
@if (request('priority') !== null || request('state') !== null)
    <button ...>Clear filters</button>
@else
    <button ... disabled ...>Clear filters</button>
@endif
```

## Scopes usage.
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
