<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class LogTaskCreation
{
    public function __construct()
    {
        //
    }

    public function handle(TaskCreated $event): void
    {
        $taskId = $event->task->id;
        Log::channel('taskCreation')->info("Task creation: $taskId");
    }
}
