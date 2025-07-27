<?php

namespace App\Enums;

enum Priority: int
{
    case HIGH = 0; 
    case MEDIUM = 1; 
    case LOW = 2; 

    public function label(): string
    {
        return match($this) {
            self::HIGH => "High",
            self::MEDIUM=> "Medium",
            self::LOW => "Low",
        };
    }
}
