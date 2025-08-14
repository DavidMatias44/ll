# Testing.

## How to run the tests.

### You can run all tests using:
```bash
php artisan test
```

### If you want to run a specific test file use:
```bash
php artisan test --filter FileTestName
```

## Directory structure.
The tests are stored in `/test/Feature/`
Current organization:
- `Policies/`: Policy tests.
- `Tasks/`: CRUD tests for `Task`.

## `beforeEach` usage.
This method is used to set up things before each method runs. (Vary per file).

## Test data.
- Uses `UserFactory` and `TaskFactory` for generating data.
