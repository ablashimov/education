<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyUserEmailRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class AuthController extends Controller
{
    /**
     * @throws Throwable
     */
    public function login(LoginRequest $request): UserResource|JsonResponse
    {
        try {
            $authorizedViaSession = Auth::guard('web')->check();
            $authorizedViaRememberToken = Auth::guard('web')->viaRemember();

            $authorizedByCredentials = false;
            if (! ($authorizedViaSession || $authorizedViaRememberToken)) {
                $authorizedByCredentials = Auth::guard('web')->attempt(
                    credentials: $request->only('email', 'password'),
                    remember: $request->get('remember')
                );
            }

            if ($authorizedViaSession || $authorizedViaRememberToken || $authorizedByCredentials) {
                /** @var User $user */
                $user = Auth::guard('web')->user();

                $message = null;
                $organization = $user->organization;
                if (! $organization) {
                    $message = __('auth.organization_not_found');
                    $reason = 'organization_not_found';
                } elseif ($organization->status->slug === StatusEnum::VERIFICATION) {
                    $message = __('auth.organization_not_verified');
                    $reason = 'organization_not_verified';
                } elseif ($organization->status->slug === StatusEnum::INACTIVE) {
                    $message = __('auth.organization_not_active');
                    $reason = 'organization_not_active';
                }

                if ($message !== null) {
                    Auth::guard('web')->logout();
                    return response()->json(
                        ['message' => $message, 'reason' => $reason ?? 'undefined'],
                        SymfonyResponse::HTTP_UNAUTHORIZED
                    );
                }

                setPermissionsTeamId($organization->id);
                $user->load(['roles', 'permissions']);

                $request->session()->regenerate();

                return UserResource::make($user);
            }

            return response()->json(['message' => __('auth.failed')], SymfonyResponse::HTTP_UNAUTHORIZED);
        } catch (Throwable $exception) {
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
            }

            if (! App::isLocal()) {
                return response()->json([
                    'status_code' => $exception->getCode(),
                    'message' => 'Service is unavailable',
                    'error' => $exception->getMessage(),
                ], SymfonyResponse::HTTP_UNAUTHORIZED);
            }

            throw $exception;
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(__('auth.failed'), SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } else {
            $user->currentAccessToken()->delete();
        }

        return response()->json(__('User was successfully logout'));
    }

    public function sendEmailVerification(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(__('auth.failed'), SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent']);
    }

    public function verifyEmail(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(__('auth.failed'), SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        $request->validate([
            'id' => 'required|integer',
            'hash' => 'required|string',
        ]);

        $id = $request->input('id');
        $hash = $request->input('hash');

        if ($id != $user->id) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        if (! hash_equals((string) $user->getKey(), (string) $id)) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully']);
    }
}
