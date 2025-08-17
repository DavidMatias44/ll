# Laravel Email Verification.

Restricts  access to certain views or resources until a user confirms their email address.
Laravel provide a **ready to use** email verification system, the views, routes and methods already exist.

## Implementation.

- I added `implements MustVerifyEmail` to the User model.
(`MustVerifyEmail` is an interface that "tells" Laravel to require email verification for this model).
```php
class User extends Authenticatable implements MustVerifyEmail
{
    ...
}
```

The User model by default has the `email_veried_at` column:
```php
class User extends Authenticatable implements MustVerifyEmail
{
    ...
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    ...
}
```

- I modified the `verify-email` Blade view to style it with vanilla CSS.

- Then, I added the `verified` middleware to protect certain views or resources:
```php
Route::middleware(['auth', 'verified'])->group(function () {
    // protected routes
}
```

## Notes.
- Laravel automatically sends the verification email after a user registration.
- I use `mailpit` to received emails. I installed it following the commands (I am using Debian 12):
```bash
wget https://github.com/axllent/mailpit/releases/latest/download/mailpit-linux-amd64.tar.gz
tar -xzf mailpit-linux-amd64.tar.gz
sudo mv mailpit /usr/local/bin/
```

Execute `mailpit`:
```bash
mailpit
```
