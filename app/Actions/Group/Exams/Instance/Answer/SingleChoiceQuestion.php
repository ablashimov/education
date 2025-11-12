<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\DTO\AnswerDTO;
use App\DTO\ProcessedAnswerDTO;
use App\Exception\ValidationException;
use App\Interfaces\QuestionHandlerInterface;
use App\Models\Question;

readonly class SingleChoiceQuestion implements QuestionHandlerInterface
{
    public function execute(Question $question, AnswerDTO $dto): ProcessedAnswerDTO
    {
        if (empty($dto->choiceIds)) {
            throw new ValidationException('Некоректний варіант відповіді');
        }
        $answerId = (int)$dto->choiceIds[0];
        $allowed = $question->choices->pluck('text', 'id')->toArray();

        if (! isset($allowed[$answerId])) {
            throw new ValidationException('Некоректний варіант відповіді');
        }

        $correct = $question->choices->where('correct', true)->first();
        $isCorrect = $correct->id === $answerId;

        return new ProcessedAnswerDTO(
            questionId: $question->id,
            questionChoiceIds: [['question_choice_id' => $answerId]],
            answer: $allowed[$answerId],
            isCorrect: $isCorrect,
            score: $isCorrect ? $question->score : 0
        );
    }
}
