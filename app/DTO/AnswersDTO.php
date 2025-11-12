<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\Group\StoreInstanceAnswerRequest;

final readonly class AnswersDTO
{
    public function __construct(
        public array $answers,
        public int $examInstanceId,
        public int $attemptId,
        public int $userId,
    ) {
    }

    public static function fromRequest(StoreInstanceAnswerRequest $request): self
    {
        $data = [];
        foreach ($request->get('answers') as $answer) {
            $dto = AnswerDTO::fromArray($answer);
            $data[$dto->questionId] = $dto;
        }

        return new self(
            answers: $data,
            examInstanceId: (int) $request->input('exam_instance_id'),
            attemptId: (int) $request->input('attempt_id'),
            userId: (int) $request->input('user_id'),
        );
    }
}
