<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\Instance\Answer\StoreAttempt;
use App\Actions\Group\Exams\Instance\CreateExamInstance;
use App\Actions\Group\Exams\Instance\GetExamInstance;
use App\Actions\Group\Exams\Instance\GetExamInstanceResult;
use App\Actions\Group\Exams\Instance\GetExamInstances;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Exam\AttemptResource;
use App\Http\Resources\Course\Exam\ExamInstanceResource;
use App\Models\ExamInstance;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExamInstanceAttemptController extends Controller
{
    public function show(ExamInstance $examInstance, int $attemptId, GetExamInstanceResult $action): AttemptResource
    {
        $instance = $action->execute($examInstance->id, $attemptId);

        return AttemptResource::make($instance);
    }
}
