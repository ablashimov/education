<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\AdminUser;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class GroupPolicy extends BasePolicy
{
    public function view(User|AdminUser $authUser, Group $group): Response
    {
        if (
            $this->isAdminPanelAction()
            || ($group->users->contains($authUser->id)
                && $group->start_date->lte(Carbon::now()) && $group->end_date->gte(Carbon::now())
            )
        ) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function viewAvailable(User|AdminUser $authUser, Group $group): Response
    {
        if ($this->isAdminPanelAction()
            || ($authUser->hasRole(RoleEnum::ADMIN) && $group->start_date->gt(Carbon::now()->endOfDay()))
        ) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function update(User|AdminUser $authUser, Group $group): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function delete(User|AdminUser $authUser, Group $group): Response
    {
        if ($this->isAdminPanelAction()) {
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

    public function restore(User|AdminUser $authUser, Group $group): Response
    {
        return Response::deny();
    }

    public function forceDelete(User|AdminUser $authUser, Group $group): Response
    {
        return Response::deny();
    }
}
