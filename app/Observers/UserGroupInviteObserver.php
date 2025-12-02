<?php

namespace App\Observers;

use App\Events\GroupRequestApproved;
use App\Models\UserGroupInvite;
use Filament\Facades\Filament;

class UserGroupInviteObserver
{
    public function updating(UserGroupInvite $invite): void
    {
        if (Filament::isServing() && ! $invite->getOriginal('accepted_at')) {
            $invite->user->notify(new GroupRequestApproved($invite->group, $invite->user_id));
        }
    }
}
