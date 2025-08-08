# Laravel Paginator.

## What I implemented.

I created a **custom-paginator view** styled with vanilla CSS.
So, I have to:

- **Publish** the paginator:
```bash
php artisan vendor:publish --tag=laravel-paginator
```
this command copy the pagination templates from `vendor/laravel/framework` directory into `resources/view/vendor/pagination` directory.

- Delete all Blade files except for `default.blade.php`.

- Set the **Default Paginator View**, by adding:
```php
Paginator::defaultView('vendor.pagination.default');
```
to the **AppServiceProvider**.
