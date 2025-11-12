<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\DTO\AnswerDTO;
use App\DTO\ProcessedAnswerDTO;
use App\Interfaces\QuestionHandlerInterface;
use App\Models\Question;

readonly class CustomChoiceQuestion implements QuestionHandlerInterface
{
    public function execute(Question $question, AnswerDTO $dto): ProcessedAnswerDTO
    {
        return new ProcessedAnswerDTO(
            questionId: $dto->questionId,
            answer: $dto->text,
        );
    }
}
