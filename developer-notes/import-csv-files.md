# Csv file import.

This feature allows the user to perform insertion of `Tasks` into the database.
The large files may take a considerable amount of time I decided to do this implementation using `Jobs` and `Queues`.
- A `Job` is class that encapsulates the logic of a task to be performed. The `Jobs` use `Queues`.
- `Queues` store jobs waiting to be processed. 
In this implementation I used the `database` queue driver (`QUEUE_CONNECTION=database`) which stores jobs in the `jobs` table.
Once the `Tasks` insertion finishes, the user receives a `notification`.

**Benefits**:
- Handle large file uploads without blocking the request/response cycle.
- Notifies the user once the process is completed.

## Implementation.

### Files created:
- View: `resources\views\tasks\import-form.blade.php`
```bash
php artisan make:view tasks/import-form
```

- Controller: `app\Http\Controllers\TaskImportController.php`
```bash
php artisan make:controller TaskImportController
```

- Form Request: `app\Http\Requests\ImportTasksFromCsvRequest.php`
```bash
php artisan make:request ImportTasksFromCsvRequest
```

- Job: `app\Jobs\ImportCsvFile`.
```bash
php artisan make:job ImportCsvFile
```

- Notification: `app\Notifications\CsvImportCompleted`.
```bash
php artisan make:notification CsvImportCompleted
```

Inside the `TaskImportController` there is a method called `importCsv` it receives a `request` of type `ImportTasksFromCsvRequest`.
Store the validated uploaded file and get its full path.
Then call the method `dispatch()` of the job `ImportCsvFile`, its parameters are `fullPath` and the current authenticated user.
It return a redirect to the dashboard route.
```php
public function importCsv(ImportTasksFromCsvRequest $request)
{
    $file = $request->file('csv-file');
    $disk = config('filesystems.default');

    $path = $file->store('csv-files', $disk);
    $fullPath = Storage::disk($disk)->path($path);

    ImportCsvFile::dispatch($fullPath, Auth::user());

    return redirect()->route('dashboard')->withSuccess('Your tasks willbe processed.');
}
```

As mentioned above the job receives two paramaters.
```php
...
public $filePath;

public $user;

public function __construct(string $filePath, User $user)
{
    $this->filePath = $filePath;
    $this->user = $user;
}
...
```

With those variables I am able to:
- Get the content of the file.
- Get the user's id and send a notification via email.
```php
public function handle(): array
{
    $handle = fopen($this->filePath, 'r');
    $errors[];
    ...

    while (($row = fgetcsv($handle)) != false) {
        // validation logic. Errors are added to the $errors array.

        $csvData['user_id'] = $this->user->id;

        // insertion logic
    }

    $this->user->notify(new CsvImportCompleted($errors));
}
```

The notification receives the errors found during the task insertion.
```php
public $errors;

public function __construct(array $errors)
{
    $this->errors = $errors;
}
```

Then the mail body is constructed and send it to the user:
```php
public function toMail(object $notifiable): MailMessage
{
    $mail = (new MailMessage)->subject('Csv file import results');

    if (count($this->errors) > 0) {
        $mail->line('Errors ocurred during the csv file import: ');
        foreach ($this->errors as $error) {
            $mail->line(" - $error");
        }
    } else {
        $mail->line('No errors ocurred during the csv file import.');
    }

    return $mail;
}
```
This notification message also includes the errors that occured during the insertion process if exist.
