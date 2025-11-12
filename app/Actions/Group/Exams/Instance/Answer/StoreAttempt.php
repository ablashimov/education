<?php

namespace App\Actions\Group\Exams\Instance\Answer;

use App\Interfaces\Repositories\AttemptRepositoryInterface;
use App\Models\ExamAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;

readonly class StoreAttempt
{
    public function __construct(
        private AttemptRepositoryInterface $repository,
    ) {
    }

    public function execute(int $instanceId, Request $request): ExamAttempt
    {
        return $this->repository->create([
            'exam_instance_id' => $instanceId,
            'started_at' => Carbon::now(),
            'client_info' => $request->userAgent(),
            'ip' => $request->getClientIp(),
        ]);
    }
}
