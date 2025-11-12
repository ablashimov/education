<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\DTO\AnswersDTO;
use App\Enums\ExamResultStatusEnum;
use App\Enums\QuestionTypeEnum;
use App\Exception\ValidationException;
use App\Interfaces\Repositories\AnswerRepositoryInterface;
use App\Interfaces\Repositories\AttemptRepositoryInterface;
use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\ExamInstance;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

readonly class SaveAttemptAnswers
{
    public function __construct(
        private AttemptRepositoryInterface $repository,
        private ExamInstanceRepositoryInterface $examInstanceRepository,
        private ExamAssignmentRepositoryInterface $userExamAssignmentRepository,
        private ExamResultStatusRepositoryInterface $resultStatusRepository,
        private AnswerRepositoryInterface $answerRepository
    ) {
    }

    public function execute(AnswersDTO $dto): ExamAttempt
    {
        /** @var ExamInstance $examInstance */
        $examInstance = $this->examInstanceRepository->getById(
            $dto->examInstanceId,
            ['questions.type', 'questions.choices', 'assignment.exam']
        );
        $results = [];
        $needGrade = false;
        $score = 0;
        foreach ($examInstance->questions as $question) {
            if (empty($dto->answers[$question->id])) {
                throw new ValidationException('Надані некоректні відповіді');
            }

            $handler = new QuestionAnswerFactory()->getHandler($question->type->slug);

            if ($question->type->slug === QuestionTypeEnum::NAPISATI_VIDPOVID) {
                $needGrade = true;
            }
            $result = $handler->execute($question, $dto->answers[$question->id]);
            $results[] = $result->toArray();
            $score += $result->score;
        }

        return DB::transaction(function () use ($results, $dto, $score, $needGrade, $examInstance) {
            /** @var ExamAttempt $attempt */
            $attempt = $this->repository->getById($dto->attemptId);
            $now = Carbon::now();
            $timeLimit = $examInstance->assignment->exam->time_limit;
            $diff = $now->diffInMinutes($attempt->started_at);

            if ($diff > $timeLimit) {
                $score = 0;
            }

            $this->repository->updateModel(
                $attempt,
                [
                    'submitted_at' => $now,
                    'elapsed_seconds' => (int)$attempt->started_at->diffInSeconds($now),
                    'score' => $score,
                ]
            );

            foreach ($results as $result) {
                $result['exam_attempt_id'] = $attempt->id;
                /** @var ExamAnswer $answer */
                $answer = $this->answerRepository->create(\Arr::except($result, ['question_choice_ids']));
                if (! empty($result['question_choice_ids'])) {
                    $answer->choices()->createMany($result['question_choice_ids']);
                }
            }

            if ($needGrade) {
                $status = $this->resultStatusRepository->findBy(['slug' => ExamResultStatusEnum::CHECKING]);
            } elseif ($score > $examInstance->assignment->exam->pass_score) {
                $status = $this->resultStatusRepository->findBy(['slug' => ExamResultStatusEnum::PASSED]);
            } elseif ($examInstance->assignment->instances()->count() >= $examInstance->assignment->attempts_allowed) {
                $status = $this->resultStatusRepository->findBy(['slug' => ExamResultStatusEnum::NOT_PASSED]);
            }

            if (isset($status)) {
                $this->userExamAssignmentRepository->updateModel(
                    $examInstance->assignment,
                    ['exam_result_status_id' => $status->id]
                );
            }


            $attempt->load(['answers.question.choices', 'answers.choices']);
            $attempt->setRelation('instance', $examInstance);

            return $attempt;
        });
    }
}
