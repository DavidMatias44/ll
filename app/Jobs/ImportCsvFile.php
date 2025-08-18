<?php

namespace App\Jobs;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Notifications\CsvImportCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Validator;

class ImportCsvFile implements ShouldQueue
{
    use Queueable;

    public $filePath;

    public $user;

    public function __construct(string $filePath, User $user)
    {
        $this->filePath = $filePath;
        $this->user = $user;
    }

    public function handle(): array
    {
        $handle = fopen($this->filePath, 'r');
        $errors = [];

        $expectedHeaderValues = ['name', 'description', 'state', 'priority'];
        $headerValues = fgetcsv($handle);
        if ($expectedHeaderValues !== $headerValues) {
            fclose($handle);

            $errors[] = 'Invalid header format. Header values must be: name,description,state,priority';

            return $errors;
        }

        $lineNumber = 2;
        while (($row = fgetcsv($handle)) != false) {
            if (count($row) != count($headerValues)) {
                $errors[] = "Line: $lineNumber - Invalid number of columns";
                $lineNumber++;

                continue;
            }

            $csvData = array_combine($headerValues, $row);

            $validator = Validator::make($csvData, (new CreateTaskRequest)->rules());
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $errors[] = "Line: $lineNumber - $message";
                }
                $lineNumber++;

                continue;
            }

            $csvData['user_id'] = $this->user->id;

            Task::create($csvData);
            $lineNumber++;
        }
        fclose($handle);

        $this->user->notify(new CsvImportCompleted($errors));
    }
}
