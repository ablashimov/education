<?php

declare(strict_types=1);

namespace App\Enums;

enum ExamResultStatusEnum: string
{
    case ASSIGNED = 'assigned';
    case IN_WORK = 'in_work';
    case NOT_PASSED = 'not_passed';
    case PASSED = 'passed';
    case CHECKING = 'checking';

    public function title(): string
    {
        return match ($this) {
            self::ASSIGNED => 'Призначений',
            self::IN_WORK => 'В роботі',
            self::NOT_PASSED => 'Не зданий',
            self::PASSED => 'Здано',
            self::CHECKING => 'Триває перевірка',
        };
    }
}
