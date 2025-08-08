# Laravel Email Verification.

Restricts  access to certain views or resources until a user confirms their email address.
Laravel provide a **ready to use** email verification system, the views, routes and methods already exist.

## What I implemented.

- I added `implements MustVerifyEmail` to the User model.
(`MustVerifyEmail` is an interface that "tells" Laravel to require email verification for this model).
(The User model by default has the `email_veried_at` column).

- I modified the `verify-email` Blade view to style it with vanilla CSS.

- Then, I added the `verified` middleware to protect certain views or resources. Example:
```php
Route::middleware(['auth', 'verified'])->group(function () {
    // protected routes
}
```

## Notes.
- Laravel automatically sends the verification email when a user registers.
