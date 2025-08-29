<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Pomodoro\State;
use App\Models\Pomodoro;
use Auth;

class PomodoroTimer extends Component
{
    public State $pomodoroState = State::POMODORO;
    public int $currentPomodoro = 1;
    public bool $timerIsRunning = false;
    public int $timeLeftInSeconds;          

    public function mount()
    {
        if (session('pomodoro.currentPomodoro') === null) {
            session()->put([
                'pomodoro.currentPomodoro' => $this->currentPomodoro,
                'pomodoro.timerIsRunning' => $this->timerIsRunning,
                'pomodoro.state' => $this->pomodoroState,
                'pomodoro.timeLeftInSeconds' => $this->pomodoroState->getTotalTime(),
            ]);
            $this->timeLeftInSeconds = $this->pomodoroState->getTotalTime();

            return;
        }

        $this->currentPomodoro = session()->get('pomodoro.currentPomodoro');
        $this->timerIsRunning = session()->get('pomodoro.timerIsRunning');
        $this->pomodoroState = session()->get('pomodoro.state');
        $this->timeLeftInSeconds = session()->get('pomodoro.timeLeftInSeconds');

        if ($this->timerIsRunning) {
            $startedAt = session()->get('pomodoro.startedAt');
            $timeElapsed = -now()->diffInSeconds($startedAt);
            $this->timeLeftInSeconds = max(0, floor($this->pomodoroState->getTotalTime() - $timeElapsed));
        }
    }

    public function timerStart()
    {
        $this->timerIsRunning = true;
        session()->put([
            'pomodoro.startedAt'=> now(),
            'pomodoro.timerIsRunning' => $this->timerIsRunning,
        ]);
    }

    public function timerStop()
    {
        $this->timerIsRunning = false;
        session()->put([
            'pomodoro.timeLeftInSeconds' => $this->timeLeftInSeconds,
            'pomodoro.timerIsRunning' => $this->timerIsRunning,
        ]);
    }

    public function tick() 
    {
        if (!$this->timerIsRunning) {
            return;
        }

        if ($this->timeLeftInSeconds <= 0) {
            $this->skipToNextPomodoro();
        } else {
            $this->timeLeftInSeconds--;
        }
    }

    public function skipToNextPomodoro()
    {
        $this->timerStop();
        $this->changePomodoroState();

        session()->put([
            'pomodoro.currentPomodoro' => $this->currentPomodoro,
            'pomodoro.timeLeftInSeconds' => $this->pomodoroState->getTotalTime(),
            'pomodoro.state' => $this->pomodoroState
        ]);
        $this->timeLeftInSeconds = $this->pomodoroState->getTotalTime();
    }

    public function changePomodoroState()
    {
        if ($this->pomodoroState === State::POMODORO) {
            $this->pomodoroState = ($this->currentPomodoro % 4 == 0) ? State::LONG_BREAK : State::SHORT_BREAK;
            $this->storePomodoroData();
            return;
        }

        $this->pomodoroState = State::POMODORO;
        $this->currentPomodoro++;
    }

    public function storePomodoroData()
    {
        $pomodoro = new Pomodoro([
            'user_id' => Auth::id(),
            'time' => State::POMODORO->getTotalTime() - session()->get('pomodoro.timeLeftInSeconds'),
            'num_session' => $this->currentPomodoro,
        ]);
        if (session()->has('pomodoro.taskId')) {
            $pomodoro['task_id'] = session()->get('pomodoro.taskId');
        }
        $pomodoro->save();
    }

    public function render()
    {
        return view('livewire.pomodoro-timer');
    }
}
