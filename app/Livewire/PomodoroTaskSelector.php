<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Auth;

class PomodoroTaskSelector extends Component
{
    public $tasks = null;
    public $taskId;
    public $task;

    public function mount()
    {
        $userId = Auth::id();
        $this->tasks = Task::query()->whereUserId($userId)->get();
        
        if (session('pomodoro.taskId') !== null) {
            $this->taskId = session()->get('pomodoro.taskId');
            $this->task = Task::findOrFail($this->taskId);
        }
    }

    public function saveTaskId() 
    {
        session()->put('pomodoro.taskId', $this->taskId);
        $this->task = Task::findOrFail($this->taskId);
    }

    public function updateTaskId()
    {
        return;
    }

    public function removeTask()
    {
        session()->put('pomodoro.taskId', null);
        $this->taskId = null;
    }

    public function render()
    {
        return view('livewire.pomodoro-task-selector');
    }
}
