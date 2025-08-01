<?php

namespace App\Enums;

enum State: int
{
    case TODO = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;

    public function label(): string
    {
        return match($this) {
            self::TODO => "To Do",
            self::IN_PROGRESS => "In progress",
            self::COMPLETED  => "Completed",
        };
    }
}
