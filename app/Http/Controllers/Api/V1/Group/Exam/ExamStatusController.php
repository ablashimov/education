<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\GetExamResultStatuses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Exam\ExamResultStatusResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExamStatusController extends Controller
{
    public function index(GetExamResultStatuses $action): AnonymousResourceCollection
    {
        $statuses = $action->execute();

        return ExamResultStatusResource::collection($statuses);
    }
}
