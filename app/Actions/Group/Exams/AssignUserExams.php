<?php

namespace App\Actions\Group\Exams;

use App\Enums\ExamResultStatusEnum;
use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\GroupExamSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

readonly class AssignUserExams
{
    public function __construct(
        private ExamAssignmentRepositoryInterface $repository,
        private ExamResultStatusRepositoryInterface $resultStatusRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(GroupExamSchedule $examSchedule): void
    {
        DB::transaction(function () use ($examSchedule) {
            $status = $this->resultStatusRepository->findBy(['slug' => ExamResultStatusEnum::ASSIGNED]);
            $users = $this->userRepository->getGroupUsers($examSchedule->group_id);
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    'exam_id' => $examSchedule->exam_id,
                    'group_id' => $examSchedule->group_id,
                    'is_control' => true,
                    'user_id' => $user->id,
                    'exam_result_status_id' => $status->id,
                    'attempts_allowed' => $examSchedule->exam->attempts_allowed,
                    'start_at' => $examSchedule->start_at,
                    'end_at' => $examSchedule->end_at,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $this->repository->insert($data);
        });
    }
}
