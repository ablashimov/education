<?php

namespace App\Http\Controllers\Api\V1\Group;

use App\Actions\Group\GetUserGroup;
use App\Actions\Group\PaginateUserGroups;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Group\GroupCollection;
use App\Http\Resources\Group\GroupResource;
use App\Models\Group;

class UserGroupController extends Controller
{
    public function index(PaginateRequest $request, PaginateUserGroups $action): GroupCollection
    {
        $groups = $action->execute(PaginateDTO::fromRequest($request), auth()->user()->id);

        return GroupCollection::make($groups);
    }

    public function show(Group $group, GetUserGroup $getGroup): GroupResource
    {
        $group = $getGroup->execute($group->id, auth()->user()->id);

        return GroupResource::make($group);
    }
}
