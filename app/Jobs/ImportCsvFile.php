<?php

namespace App\Jobs;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Validator;

class ImportCsvFile implements ShouldQueue
{
    use Queueable;

    public $filePath;
    public $userId;

    public function __construct(string $filePath, int $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
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

            $csvData['user_id'] = $this->userId;

            Task::create($csvData);
            $lineNumber++;
        }
        fclose($handle);

        if (! empty($errors)) {
            // event to return and notify the errors.
        }
    }
}
