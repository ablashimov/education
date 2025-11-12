<?php

namespace App\Http\Controllers\Api\V1\Group\Exam;

use App\Actions\Group\Exams\Instance\Answer\SaveAttemptAnswers;
use App\DTO\AnswersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\StoreInstanceAnswerRequest;
use App\Http\Resources\Course\Exam\AttemptResource;

class ExamAnswerController extends Controller
{
    public function store(StoreInstanceAnswerRequest $request, SaveAttemptAnswers $action): AttemptResource
    {
        $dto = AnswersDTO::fromRequest($request);
        $instance = $action->execute($dto);

        return AttemptResource::make($instance);
    }

}
