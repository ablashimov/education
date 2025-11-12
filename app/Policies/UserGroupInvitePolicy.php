<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserGroupInvitePolicy extends BasePolicy
{
    public function delete(User|AdminUser $authUser): Response
    {
        if ($this->baseCheck($authUser)) {
            return Response::allow();
        }

        return Response::deny();
    }
}
