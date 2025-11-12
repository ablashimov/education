<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionEnum: string
{
    // Слаги (поле name) пермишенов.
    // view_ - это префикс.
    // По префиксам в ресурсах Filament можно фильтровать доступные пермишены для конкретного ресурса
    // user это модель, для которой будет показан пермишен
    // если модель вида AdminUser то модель нужно указать так - admin::user

    //Users
    case VIEW_USER = 'view_user';
    case CREATE_USER = 'create_user';
    case UPDATE_USER = 'update_user';
    case DELETE_USER = 'delete_user';

    public function title(): string
    {
        return match ($this) {
            self::VIEW_USER => __('permissions.view'),
            self::CREATE_USER => __('permissions.create'),
            self::UPDATE_USER => __('permissions.update'),
            self::DELETE_USER => __('permissions.delete'),
        };
    }
}
