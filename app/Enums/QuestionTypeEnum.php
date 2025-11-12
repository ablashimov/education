<?php

declare(strict_types=1);

namespace App\Enums;

enum QuestionTypeEnum: string
{
    case MNOZHINNYJ_VYBIR = 'mnozhinnyj_vybir';
    case ODINOKIJ_VYBIR = 'odinokij_vybir';
    case NAPISATI_VIDPOVID = 'napisati_vidpovid';
    case VYBIR_POSLIDOVNOSTI = 'vybir_poslidovnosti';

    public function title(): string
    {
        return match ($this) {
            self::MNOZHINNYJ_VYBIR => 'Множинний вибір',
            self::ODINOKIJ_VYBIR => 'Одиночний вибір',
            self::NAPISATI_VIDPOVID => 'Написати відповідь',
            self::VYBIR_POSLIDOVNOSTI => 'Вибір послідовності',
        };
    }
}
