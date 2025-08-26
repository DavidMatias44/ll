<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Pomodoro\State;

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

        session()->put('pomodoro.currentPomodoro', $this->currentPomodoro);
        session()->put('pomodoro.timeLeftInSeconds', $this->pomodoroState->getTotalTime());
        session()->put('pomodoro.state', $this->pomodoroState);
        $this->timeLeftInSeconds = $this->pomodoroState->getTotalTime();
    }

    public function render()
    {
        return view('livewire.pomodoro-timer');
    }
}
