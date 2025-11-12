<?php

namespace App\Http\Controllers\Api\V1\Group;

use App\Actions\Group\Invites\CreateUserInvite;
use App\Actions\Group\Invites\DeleteUserInvite;
use App\Actions\Group\Invites\PaginateAvailableUser;
use App\Actions\Group\Invites\PaginateUserInvites;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\InviteRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Group\UserGroupInviteResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class InviteController extends Controller
{
    public function index(PaginateRequest $request, PaginateUserInvites $action): AnonymousResourceCollection
    {
        $invite = $action->execute(PaginateDTO::fromRequest($request), $request->route('groupId'));

        return UserGroupInviteResource::collection($invite);
    }

    public function store(InviteRequest $request, CreateUserInvite $action): UserGroupInviteResource
    {
        $invite = $action->execute($request->get('user_id'), $request->input('group_id'));

        return UserGroupInviteResource::make($invite);
    }

    public function delete(int $groupId, int $inviteId, DeleteUserInvite $action): Response
    {
        $action->execute($inviteId, auth()->user()->organization_id);

        return \response()->noContent();
    }

    public function availableUsers(PaginateRequest $request, int $groupId, PaginateAvailableUser $action): UserCollection
    {
        $users = $action->execute(PaginateDTO::fromRequest($request), $groupId);

        return UserCollection::make($users);
    }
}
