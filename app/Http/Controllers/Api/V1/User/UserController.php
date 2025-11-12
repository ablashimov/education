<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\User\DeleteUser;
use App\Actions\User\GetUser;
use App\Actions\User\PaginateUsers;
use App\Actions\User\StoreUser;
use App\Actions\User\UpdateUser;
use App\DTO\PaginateDTO;
use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(PaginateRequest $request, PaginateUsers $action): UserCollection
    {
        $sensors = $action->execute(PaginateDTO::fromRequest($request));

        return UserCollection::make($sensors);
    }

    public function show(User $user, GetUser $getUser): UserResource
    {
        $user = $getUser->execute($user->id);

        return UserResource::make($user);
    }

    public function store(StoreUserRequest $request, StoreUser $action): UserResource
    {
        $dto = UserDTO::fromRequest($request);
        $user = $action->execute($dto);

        return UserResource::make($user);
    }

    public function edit(EditUserRequest $request, User $user, UpdateUser $action): UserResource
    {
        $dto = UserDTO::fromRequest($request);
        $user = $action->execute($dto, $user);

        return UserResource::make($user);
    }

    public function delete(User $user, DeleteUser $action): Response
    {
        $action->execute($user);

        return \response()->noContent();
    }

    public function authUser(): UserResource
    {
        /** @var User $user */
        $user = Auth::guard('sanctum')->user();
        $user->load(['roles', 'organization']);

        return UserResource::make($user);
    }
}
