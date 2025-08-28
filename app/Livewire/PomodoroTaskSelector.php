<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Tasks\State;
use App\Models\Task;
use Auth;

class PomodoroTaskSelector extends Component
{
    public $tasks = null;
    public $taskId = null;
    public $task = null;

    public function mount()
    {
        $this->loadTasks();
        $this->loadSelectedTask();
    }

    public function loadTasks()
    {
        $this->tasks = Task::query()
            ->whereUserId(Auth::id())
            ->where('state', '<', State::COMPLETED)
            ->get();
    }

    public function loadSelectedTask()
    {  
        $taskId = session()->get('pomodoro.taskId');
        if ($taskId) {
            $this->task = Task::findOrFail($taskId);
        }
    }

    public function saveTaskId() 
    {
        /*
            At this point $this->taskId is not null.
            The button calling this function only appears when ($this->taskId != null).
        */
        session()->put('pomodoro.taskId', $this->taskId);
        $this->loadSelectedTask();
        $this->resetTaskId();
    }

    public function resetTaskId()
    {
        $this->taskId = null;
    }

    public function removeTask()
    {
        session()->forget('pomodoro.taskId');
    }

    public function updateTaskId()
    {
        return;
    }

    public function render()
    {
        return view('livewire.pomodoro-task-selector');
    }
}
