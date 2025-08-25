<?php

namespace App\Enums\Tasks;

enum State: int
{
    case TODO = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;

    public function label(): string
    {
        return match ($this) {
            self::TODO => 'To Do',
            self::IN_PROGRESS => 'In progress',
            self::COMPLETED => 'Completed',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::TODO => 'text-red-600 dark:text-red-400',
            self::IN_PROGRESS => 'text-yellow-600 dark:text-yellow-400',
            self::COMPLETED => 'text-green-600 dark:text-green-400',
        };
    }
}
