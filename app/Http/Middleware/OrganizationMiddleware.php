<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class OrganizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user) {
            return $next($request);
        }

        $organization = $user->organization;
        $message = null;
        if (! $organization) {
            $message = __('auth.organization_not_found');
        } elseif ($organization->status->slug === StatusEnum::VERIFICATION) {
            $message = __('auth.organization_not_verified');
        } elseif ($organization->status->slug === StatusEnum::INACTIVE) {
            $message = __('auth.organization_not_active');
        }
        if ($message) {
            return response()->json(['message' => $message], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        setPermissionsTeamId($user->organization_id);

        return $next($request);
    }
}
