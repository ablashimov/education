<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case MANAGER = 'manager';
    case USER = 'user';
    case ADMIN = 'admin';

    public function title(): string
    {
        return match ($this) {
            self::MANAGER => __('roles.manager'),
            self::USER => __('roles.user'),
            self::ADMIN => __('roles.admin'),
        };
    }
}
