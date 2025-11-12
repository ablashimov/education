<?php

namespace App\Actions\Group\Exams\Instance;

use App\Interfaces\Repositories\ExamQuestionRepositoryInterface;
use App\Models\ExamInstance;
use App\Models\ExamQuestion;
use Illuminate\Support\Collection;

readonly class CreateExamInstanceQuestion
{
    public function __construct(
        private ExamQuestionRepositoryInterface $questionRepository,
    ) {
    }

    public function execute(ExamInstance $examInstance, int $examId): void
    {
        /** @var Collection<ExamQuestion> $examQuestions */
        $examQuestions = $this->questionRepository->getRandom(config('services.question.count'), $examId);

        $data = [];
        foreach ($examQuestions as $question) {
            $data[] = [
                'exam_instance_id' => $examInstance->id,
                'question_id' => $question->question_id,
            ];
        }
        $examInstance->instanceQuestions()->insert($data);
    }
}
