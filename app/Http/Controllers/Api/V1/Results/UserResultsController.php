<?php

namespace App\Http\Controllers\Api\V1\Results;

use App\Actions\Result\GetUserResult;
use App\Actions\Result\GetUserResults;
use App\DTO\PaginateDTO;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Course\Exam\ExamAssigmentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserResultsController extends Controller
{
    public function index(PaginateRequest $request, GetUserResults $action): AnonymousResourceCollection
    {
        $all = $request->get('all');
        $user = auth()->user();
        $organizationId = $user->hasRole(RoleEnum::ADMIN) && $all ? auth()->user()->organization_id : null;
        $results = $action->execute(PaginateDTO::fromRequest($request), $user->id, $organizationId);

        return ExamAssigmentResource::collection($results);
    }

    public function show(int $assignedExamId, GetUserResult $action): ExamAssigmentResource
    {
        $result = $action->execute($assignedExamId, auth()->user()->id);

        return ExamAssigmentResource::make($result);
    }
}
