<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    public function view(User|AdminUser $authUser, User $user): Response
    {
        if ($this->isAdminPanelAction()
            || ($user->organization_id === $authUser->organization_id && $this->isAdmin($authUser))
        ) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function update(User|AdminUser $authUser, User $user): Response
    {
        if ($this->isAdminPanelAction()
            || $authUser->id === $user->id
            || ($user->organization_id === $authUser->organization_id && $this->isAdmin($authUser))
        ) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function delete(User|AdminUser $authUser, User $user): Response
    {
        if ($this->isAdminPanelAction()
            || ($user->organization_id === $authUser->organization_id && $this->isAdmin($authUser) && $user->id !== $authUser->id)
        ) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function deleteAny(User|AdminUser $authUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function restore(User|AdminUser $authUser, User $user): Response
    {
        return Response::deny();
    }

    public function forceDelete(User|AdminUser $authUser, User $user): Response
    {
        return Response::deny();
    }
}
