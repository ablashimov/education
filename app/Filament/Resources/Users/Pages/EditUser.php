<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Role;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected string $roleId;
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
//            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->roleId = $data['role_id'];

        return Arr::except($data, ['role_id']);
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles(Role::find($this->roleId));
    }
}
