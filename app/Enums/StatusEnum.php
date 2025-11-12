<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusEnum: string
{
    case VERIFICATION = 'verification';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function title(): string
    {
        return match ($this) {
            self::VERIFICATION => 'Верифікація',
            self::ACTIVE => 'Активний',
            self::INACTIVE => 'Неактивний',
        };
    }
}
