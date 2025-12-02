<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Actions\User\GetAdminUsers;
use App\Events\NewGroupAvailable;
use App\Filament\Resources\Groups\GroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    protected function afterCreate(): void
    {
        $admins = app()->make(GetAdminUsers::class)->execute();

        foreach ($admins as $admin) {
            $admin->notify(new NewGroupAvailable($this->getRecord(), $admin->id));
        }
    }
}
