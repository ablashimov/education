<?php

namespace App\Http\Controllers\Api\V1\Group\Module;

use App\Actions\Group\Module\GetModule;
use App\Actions\Group\Module\Lesson\GetLesson;
use App\Actions\Group\Module\Lesson\PaginateLessons;
use App\Actions\Group\Module\PaginateModules;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Course\Lesson\LessonResource;
use App\Http\Resources\Course\ModuleResource;
use App\Models\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LessonController extends Controller
{
    public function index(
        PaginateRequest $request,
        Group $group,
        int $moduleId,
        PaginateLessons $action
    ): AnonymousResourceCollection {
        $modules = $action->execute(PaginateDTO::fromRequest($request), $moduleId, $group->course_id);

        return LessonResource::collection($modules);
    }

    public function show(
        Group $group,
        int $moduleId,
        int $lessonId,
        GetLesson $action
    ): LessonResource {
        $modules = $action->execute($moduleId, $lessonId, $group->course_id);

        return LessonResource::make($modules);
    }
}
