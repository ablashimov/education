<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Throwable;

class RoleSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        foreach ($this->getRoles() as $role) {
            /** @var Role $createdRole * */
            $createdRole = Role::query()
                ->updateOrCreate(
                    attributes: ['name' => $role['name']],
                    values: Arr::only($role, ['name', 'title', 'guard_name'])
                );

            $createdRole->syncPermissions($role['permissions'] ?? []);
        }
    }

    private function getRoles(): array
    {
        return [
            [
                'name' => RoleEnum::ADMIN->value,
                'title' => RoleEnum::ADMIN->title(),
                'guard_name' => 'web',
                'permissions' => [
                    PermissionEnum::VIEW_USER->value,
                    PermissionEnum::CREATE_USER->value,
                    PermissionEnum::UPDATE_USER->value,
                    PermissionEnum::DELETE_USER->value,
                ],
            ],
            [
                'name' => RoleEnum::MANAGER->value,
                'title' => RoleEnum::MANAGER->title(),
                'guard_name' => 'web',
                'permissions' => [
                    PermissionEnum::VIEW_USER->value,
                    PermissionEnum::CREATE_USER->value,
                    PermissionEnum::UPDATE_USER->value,
                    PermissionEnum::DELETE_USER->value,
                ],
            ],
            [
                'name' => RoleEnum::USER->value,
                'title' => RoleEnum::USER->title(),
                'guard_name' => 'web',
                'permissions' => [],
            ],
        ];
    }
}
