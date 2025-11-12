<?php

namespace App\Http\Controllers\Api\V1\Group\Module;

use App\Actions\Group\Module\GetModule;
use App\Actions\Group\Module\PaginateModules;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Course\ModuleResource;
use App\Models\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ModuleController extends Controller
{
    public function index(
        PaginateRequest $request,
        Group $group,
        PaginateModules $action
    ): AnonymousResourceCollection {
        $modules = $action->execute(PaginateDTO::fromRequest($request), $group->course_id);

        return ModuleResource::collection($modules);
    }

    public function show(
        Group $group,
        int $moduleId,
        GetModule $action
    ): ModuleResource {
        $modules = $action->execute($group->course_id, $moduleId);

        return ModuleResource::make($modules);
    }
}
