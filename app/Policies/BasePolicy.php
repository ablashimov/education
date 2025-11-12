<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\AdminUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User|AdminUser $authUser): Response
    {
        if ($this->baseCheck($authUser)) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function create(User|AdminUser $authUser): Response
    {
        if ($this->baseCheck($authUser)) {
            return Response::allow();
        }

        return Response::deny();
    }

    protected function isAdminPanelAction(): bool
    {
        return Filament::isServing();
    }

    protected function isAdmin(User $user)
    {
        return $user->hasRole(RoleEnum::ADMIN);
    }

    protected function baseCheck(User|AdminUser $authUser): bool
    {
        return $this->isAdminPanelAction() || $authUser->hasRole(RoleEnum::ADMIN);
    }
}
