<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class ProcessedAnswerDTO
{
    public function __construct(
        public int $questionId,
        public ?array $questionChoiceIds = null,
        public ?string $answer = null,
        public ?bool $isCorrect = null,
        public ?int $score = null,
    ) {}

    public function toArray(): array
    {
        return [
            'question_id' => $this->questionId,
            'question_choice_ids' => $this->questionChoiceIds,
            'answer' => $this->answer,
            'is_correct' => $this->isCorrect,
            'score' => $this->score,
        ];
    }
}
