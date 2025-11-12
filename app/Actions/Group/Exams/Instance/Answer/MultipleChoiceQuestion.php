<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\DTO\AnswerDTO;
use App\DTO\ProcessedAnswerDTO;
use App\Exception\ValidationException;
use App\Interfaces\QuestionHandlerInterface;
use App\Models\Question;

readonly class MultipleChoiceQuestion implements QuestionHandlerInterface
{
    public function execute(Question $question, AnswerDTO $dto): ProcessedAnswerDTO
    {
        if (empty($dto->choiceIds)) {
            throw new ValidationException('Некоректний варіант відповіді');
        }

        $answerIds = $dto->choiceIds;
        $answer = '';
        $allowed = $question->choices->pluck('text', 'id')->toArray();
        $choices = [];
        foreach ($answerIds as $answerId) {
            if (empty($allowed[$answerId])) {
                throw new ValidationException('Некоректний варіант відповіді');
            }

            $choices[] = ['question_choice_id' => $answerId];
            $answer .= $allowed[$answerId] . ';';
        }

        $correct = $question->choices->where('correct', true)->pluck('id')->toArray();
        $isCorrect = array_diff($correct, $answerIds) === [] && array_diff($answerIds, $correct) === [];

        return new ProcessedAnswerDTO(
            questionId: $question->id,
            questionChoiceIds: $choices,
            answer: $answer,
            isCorrect: $isCorrect,
            score: $isCorrect ? $question->score : 0
        );
    }
}
