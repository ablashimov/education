<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTO\AnswerDTO;
use App\DTO\ProcessedAnswerDTO;
use App\Models\Question;

interface QuestionHandlerInterface
{
    public function execute(Question $question, AnswerDTO $dto): ProcessedAnswerDTO;
}
