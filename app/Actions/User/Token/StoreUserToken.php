<?php

namespace App\Actions\User\Token;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

readonly class StoreUserToken
{
    public function execute(User $user, string $tokenName, ?string $expiresAt = null): PersonalAccessToken
    {
        $token = $user->createToken(
            $tokenName,
            ['*'],
            Carbon::parse($expiresAt)
        );

        $token->accessToken->token = $token->plainTextToken;

        return $token->accessToken;
    }
}
