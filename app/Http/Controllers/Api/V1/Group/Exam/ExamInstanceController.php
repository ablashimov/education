<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\Instance\Answer\StoreAttempt;
use App\Actions\Group\Exams\Instance\CreateExamInstance;
use App\Actions\Group\Exams\Instance\GetExamInstance;
use App\Actions\Group\Exams\Instance\GetExamInstances;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Exam\ExamInstanceResource;
use App\Models\ExamAssignment;
use App\Models\ExamInstance;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExamInstanceController extends Controller
{
    public function index(Group $group, ExamAssignment $assignedExam, GetExamInstances $action): AnonymousResourceCollection
    {
        $instances = $action->execute($group->id, $assignedExam->id, auth()->user()->id);

        return ExamInstanceResource::collection($instances);
    }

    public function show(ExamInstance $examInstance, GetExamInstance $action): ExamInstanceResource
    {
//        $instance = $action->execute($examInstanceId, auth()->user()->id);
        $examInstance->loadMissing(['questions.type', 'questions.choices', 'attempt.answers']);

        return ExamInstanceResource::make($examInstance);
    }

    public function store(
        Request $request,
        Group $group,
        ExamAssignment $assignedExam,
        CreateExamInstance $action,
        StoreAttempt $storeAttempt
    ): ExamInstanceResource {
        $instance = $action->execute($assignedExam, auth()->user()->id);
        $attempt = $storeAttempt->execute($instance->id, $request);
        $instance->setRelation('attempt', $attempt);

        return ExamInstanceResource::make($instance);
    }
}
