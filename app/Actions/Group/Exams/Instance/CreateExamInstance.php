<?php

namespace App\Actions\Group\Exams\Instance;

use App\Enums\ExamResultStatusEnum;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use App\Models\ExamAssignment;
use App\Models\ExamInstance;
use Illuminate\Support\Facades\DB;

readonly class CreateExamInstance
{
    public function __construct(
        private ExamAssignmentRepositoryInterface $repository,
        private ExamResultStatusRepositoryInterface $resultStatusRepository,
        private ExamInstanceRepositoryInterface $examInstanceRepository,
        private CreateExamInstanceQuestion $createExamInstanceQuestion
    ) {
    }

    public function execute(ExamAssignment $assignedExam, int $userId): ExamInstance
    {
        return DB::transaction(function () use ($assignedExam, $userId) {
            $assignedExam->loadMissing(['resultStatus', 'instances']);
            $status = $this->resultStatusRepository->findBy(['slug' => ExamResultStatusEnum::IN_WORK]);
            $this->repository->updateModel($assignedExam, ['exam_result_status_id' => $status->id]);

            /** @var ExamInstance $examInstance */
            $examInstance = $this->examInstanceRepository->create([
                'assignment_id' => $assignedExam->id,
                'user_id' => $userId,
                'attempt_number' => $assignedExam->instances->count() + 1,
            ]);

            $this->createExamInstanceQuestion->execute($examInstance, $assignedExam->exam_id);

            return $examInstance->load(['questions.type', 'questions.choices']);
        });
    }
}
