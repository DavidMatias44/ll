# Laravel Pagination.

Laravel built in feature.

**Benefits**:
- Display large amount of data using manageable chunks.
- Reduce load times.
- Improve user experience.

To start using pagination just use the Eloquent ORM method: `paginate()`. Example:
```php
$tasks = Task::query()
    ->whereUserId($userId)
    ->paginate(5);
```

## Implementation.

I created a **custom-paginator view** styled with vanilla CSS.
So, I have to:

- **Publish** the paginator:
```bash
php artisan vendor:publish --tag=laravel-paginator
```
this command copy the pagination templates from `vendor/laravel/framework` directory into `resources/view/vendor/pagination` directory.

- Delete all Blade files except for `default.blade.php`.

- Set the **Default Paginator View**, by adding `Paginator::defaultView()` in `AppServiceProvider`'s `boot()` method:
```php
public function boot(): void
{
    ...
    Paginator::defaultView('vendor.pagination.default');
}
```

## Usage.
To be able to see the paginator links, add:
```php
{{ $tasks->links() }}
```
to the blade view.
