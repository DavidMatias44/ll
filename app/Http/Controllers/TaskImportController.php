<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class TaskImportController extends Controller
{
    public function showImportForm()
    {
        return view('tasks.import-form');
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv-file' => [
                'required',
                File::types(['csv', 'txt']),
            ],
        ]);

        $file = $request->file('csv-file');
        $handle = fopen($file->getRealPath(), 'r');

        $expectedHeaderValues = ['name', 'description', 'state', 'priority'];
        $headerValues = fgetcsv($handle);
        if (count($headerValues) != 4 || $expectedHeaderValues !== $headerValues) {
            fclose($handle);

            return redirect(route('dashboard'))
                ->with('error', 'Invalid header format. Header values must be: name,description,state,priority');
        }

        $lineNumber = 1;
        $errors = [];
        while (($row = fgetcsv($handle)) != false) {
            if (count($row) != 4) {
                continue;
            }

            $csvData = array_combine($headerValues, $row);

            $validator = Validator::make($csvData, (new CreateTaskRequest)->rules());
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $errors[] = 'Line: '.$lineNumber.' - '.$message;
                }
                $lineNumber++;

                continue;
            }

            $csvData['user_id'] = Auth::id();

            Task::create($csvData);
            $lineNumber++;
        }

        fclose($handle);

        return redirect(route('dashboard'))->withErrors($errors);
    }
}
