<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy extends BasePolicy
{
    public function viewAny(User|AdminUser $authUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function view(User|AdminUser $user, AdminUser $adminUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function create(User|AdminUser $authUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function update(User|AdminUser $user, AdminUser $adminUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function delete(User|AdminUser $user, AdminUser $adminUser): Response
    {
        if (Filament::isServing() && AdminUser::query()->count() > 1) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function deleteAny(User|AdminUser $user): Response
    {
        if (Filament::isServing() && AdminUser::query()->count() > 1) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function restore(User|AdminUser $user, AdminUser $adminUser): Response
    {
        return Response::deny();
    }

    public function forceDelete(User|AdminUser $user, AdminUser $adminUser): Response
    {
        return Response::deny();
    }
}
