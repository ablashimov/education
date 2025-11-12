<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\GetAssignedExam;
use App\Actions\Group\Exams\GetUserGroupAssignedExams;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Exam\ExamAssigmentResource;
use App\Models\ExamAssignment;
use App\Models\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupExamController extends Controller
{
    public function index(Group $group, GetUserGroupAssignedExams $action): AnonymousResourceCollection
    {
        $exams = $action->execute(auth()->user()->id, $group->id);

        return ExamAssigmentResource::collection($exams);
    }

    public function show(
        Group $group,
        ExamAssignment $assignedExam,
        GetAssignedExam $action
    ): ExamAssigmentResource {
        $assignedExam->loadMissing(['exam', 'instances.attempt.answers', 'resultStatus']);

        return ExamAssigmentResource::make($assignedExam);
    }
}
