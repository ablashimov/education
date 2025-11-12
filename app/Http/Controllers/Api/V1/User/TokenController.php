<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\User\Token\DeleteUserToken;
use App\Actions\User\Token\PaginateUserTokens;
use App\Actions\User\Token\StoreUserToken;
use App\DTO\PaginateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\User\StoreTokenRequest;
use App\Http\Resources\User\TokenCollection;
use App\Http\Resources\User\TokenResource;
use Illuminate\Http\Response;

class TokenController extends Controller
{
    public function index(PaginateRequest $request, int $user, PaginateUserTokens $action): TokenCollection
    {
        $tokens = $action->execute(PaginateDTO::fromRequest($request), $user);

        return TokenCollection::make($tokens);
    }

    public function store(StoreTokenRequest $request, StoreUserToken $action): TokenResource
    {
        $token = $action->execute(\auth()->user(), $request->get('name'), $request->get('expires_at'));

        return TokenResource::make($token);
    }

    public function delete(int $user, int $tokenId, DeleteUserToken $action): Response
    {
        $action->execute($tokenId, $user);

        return response()->noContent();
    }
}
