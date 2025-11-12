<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\GetUserGroupAssignedExams;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Exam\ExamAssigmentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExamController extends Controller
{
       public function index(GetUserGroupAssignedExams $action): AnonymousResourceCollection
    {
        $exams = $action->execute(auth()->user()->id);

        return ExamAssigmentResource::collection($exams);
    }
}
