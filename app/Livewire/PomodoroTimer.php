<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Pomodoro\State;

class PomodoroTimer extends Component
{
    public $pomodoroState = State::POMODORO;
    public $totalTimeInSeconds;

    public $currentPomodoro = 1;
    public $timerIsRunning = false;
    public $timeLeftInSeconds;

    public function mount()
    {
        if (session('pomodoro.currentPomodoro') === null && session('pomodoro.timerIsRunning') === null) {
            session()->put('pomodoro.currentPomodoro', $this->currentPomodoro);
            session()->put('pomodoro.timerIsRunning', $this->timerIsRunning);
            $this->timeLeftInSeconds = $this->pomodoroState->getTotalTime();
            return;
        }

        $this->currentPomodoro = session()->get('pomodoro.currentPomodoro');
        $this->timerIsRunning = session()->get('pomodoro.timerIsRunning');
        $this->timeLeftInSeconds = session()->get('pomodoro.timeLeftInSeconds');

        if ($this->timerIsRunning) {
            $startedAt = session()->get('pomodoro.startedAt');
            $timeElapsed = -now()->diffInSeconds($startedAt);
            $this->timeLeftInSeconds = max(0, floor($this->totalTimeInSeconds - $timeElapsed));
        }
    }

    public function timerStart()
    {
        $this->timerIsRunning = true;
        session()->put('pomodoro.startedAt', now());
        session()->put('pomodoro.timerIsRunning', $this->timerIsRunning);
    }

    public function timerStop()
    {
        $this->timerIsRunning = false;
        session()->put('pomodoro.timeLeftInSeconds', $this->timeLeftInSeconds);
        session()->put('pomodoro.timerIsRunning', $this->timerIsRunning);
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
        if ($this->pomodoroState === State::POMODORO) {
            if ($this->currentPomodoro % 4 == 0) {
                $this->pomodoroState = State::LONG_BREAK;
            } else {
                $this->pomodoroState = State::SHORT_BREAK;
            }
        } else {
            $this->pomodoroState = State::POMODORO;
            $this->currentPomodoro++;
        }
        $this->totalTimeInSeconds = $this->pomodoroState->getTotalTime();

        session()->put('pomodoro.currentPomodoro', $this->currentPomodoro);
        $this->timerStop();
        $this->timeLeftInSeconds = $this->totalTimeInSeconds;
        session()->put('pomodoro.timeLeftInSeconds', $this->totalTimeInSeconds);
    }

    public function render()
    {
        return view('livewire.pomodoro-timer');
    }
}
