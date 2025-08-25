<?php

namespace App\Enums\Tasks;

enum Priority: int
{
    case HIGH = 0;
    case MEDIUM = 1;
    case LOW = 2;

    public function label(): string
    {
        return match ($this) {
            self::HIGH => 'High',
            self::MEDIUM => 'Medium',
            self::LOW => 'Low',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::HIGH => 'text-red-600 dark:text-red-400',
            self::MEDIUM => 'text-orange-600 dark:text-orange-400',
            self::LOW => 'text-yellow-600 dark:text-yellow-400',
        };
    }
}
