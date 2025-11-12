<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\Enums\QuestionTypeEnum;
use App\Interfaces\QuestionHandlerInterface;
use InvalidArgumentException;

final class QuestionAnswerFactory
{
    protected array $types = [
        QuestionTypeEnum::ODINOKIJ_VYBIR->value => SingleChoiceQuestion::class,
        QuestionTypeEnum::MNOZHINNYJ_VYBIR->value => MultipleChoiceQuestion::class,
        QuestionTypeEnum::VYBIR_POSLIDOVNOSTI->value => SequenceChoiceQuestion::class,
        QuestionTypeEnum::NAPISATI_VIDPOVID->value => CustomChoiceQuestion::class,
    ];

    public function getHandler(QuestionTypeEnum $type): QuestionHandlerInterface
    {
        if (! isset($this->types[$type->value])) {
            throw new InvalidArgumentException("Невідомий тип питання: $type->value");
        }

        return new $this->types[$type->value];
    }
}
