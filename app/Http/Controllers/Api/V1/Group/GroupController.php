<?php

namespace App\Http\Controllers\Api\V1\Group;

use App\Actions\Group\GetGroup;
use App\Actions\Group\PaginateAvailableGroups;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Group\GroupCollection;
use App\Http\Resources\Group\GroupResource;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(PaginateRequest $request, PaginateAvailableGroups $action): GroupCollection
    {
        $sensors = $action->execute(PaginateDTO::fromRequest($request));

        return GroupCollection::make($sensors);
    }

    public function show(Group $group, GetGroup $getGroup): GroupResource
    {
        $group = $getGroup->execute($group->id);

        return GroupResource::make($group);
    }
}
