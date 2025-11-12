<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\DTO\AnswerDTO;
use App\DTO\ProcessedAnswerDTO;
use App\Exception\ValidationException;
use App\Interfaces\QuestionHandlerInterface;
use App\Models\Question;

readonly class SequenceChoiceQuestion implements QuestionHandlerInterface
{
    public function execute(Question $question, AnswerDTO $dto): ProcessedAnswerDTO
    {
        if (empty($dto->choiceIds)) {
            throw new ValidationException('Некоректний варіант відповіді');
        }

        $allowed = $question->choices->pluck('text', 'id')->toArray();
        $answer = '';
        $choices = [];
        foreach ($dto->choiceIds as $answerId) {
            if (empty($allowed[$answerId])) {
                throw new ValidationException('Некоректний варіант відповіді');
            }
            $choices[] = ['question_choice_id' => $answerId];
            $answer .= $allowed[$answerId] . ';';
        }

        $orderedAnswers = $question->choices->sortBy('order')->values();
        $isCorrect = true;

        foreach ($dto->choiceIds as $index => $answerId) {
            if ($answerId !== $orderedAnswers[$index]->id) {
                $isCorrect = false;
                break;
            }
        }

        return new ProcessedAnswerDTO(
            questionId: $question->id,
            questionChoiceIds: $choices,
            answer: $answer,
            isCorrect: $isCorrect,
            score: $isCorrect ? $question->score : 0
        );
    }
}
