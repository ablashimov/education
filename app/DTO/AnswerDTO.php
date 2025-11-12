<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class AnswerDTO
{
    public function __construct(
        public int $questionId,
        public ?array $choiceIds = null,
        public ?string $text = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            questionId: $data['question_id'],
            choiceIds: $data['choice_ids'] ?? null,
            text: $data['text'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'question_id' => $this->questionId,
            'question_choice_id' => $this->choiceIds,
            'answer' => $this->text,
        ];
    }
}
