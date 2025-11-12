<?php

namespace App\Actions\User;

use App\Interfaces\Repositories\OrganizationVerificationTokenRepositoryInterface;
use App\Mail\OrganizationVerifyMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

readonly class SendVerificationEmail
{
    public function __construct(private OrganizationVerificationTokenRepositoryInterface $repository)
    {
    }

    public function execute(User $user, string $email): bool
    {
        try {
            $token = Str::random(64);

            $this->repository->updateOrCreate(
                ['organization_id' => $user->organization_id],
                [
                    'token' => $token,
                    'expires_at' => now()->addMinutes(30),
                ]
            );

            $url = config('app.frontend_url')
                . "/authentication/callback/verify-organization?token={$token}&organizationId={$user->organization_id}";

            \Mail::to($email)->send(new OrganizationVerifyMail($user, $url));

            return true;
        } catch (Throwable $exception) {
            Log::error($exception);

            return false;
        }
    }
}
