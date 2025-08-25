<?php

namespace App\Enums\Pomodoro;

enum State: string
{
    case POMODORO = "Pomodoro";
    case LONG_BREAK = "Long break";
    case SHORT_BREAK = "Short break";

    public function getTotalTime(): int
    {
        return match ($this) {
            self::POMODORO => 25 * 60,
            self::SHORT_BREAK =>  5 * 60,
            self::LONG_BREAK => 15 * 60,
        };
    }
}
