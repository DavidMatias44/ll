<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportTasksFromCsvRequest;
use App\Jobs\ImportCsvFile;
use App\Notifications\CsvImportCompleted;
use Auth;
use Illuminate\Support\Facades\Storage;

class TaskImportController extends Controller
{
    public function showImportForm()
    {
        return view('tasks.import-form');
    }

    public function importCsv(ImportTasksFromCsvRequest $request)
    {
        $file = $request->file('csv-file');
        $disk = config('filesystems.default');

        $path = $file->store('csv-files', $disk);
        $fullPath = Storage::disk($disk)->path($path);

        ImportCsvFile::dispatch($fullPath, Auth::user());
        
        return redirect()->route('dashboard')->withSuccess('Your tasks will be processed.');
    }
}
