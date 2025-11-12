<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class PermissionSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            foreach ($this->getPermissions() as $permission) {
                Permission::query()->updateOrCreate(['name' => $permission['name']], $permission);
            }

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function getPermissions(): array
    {
        return [
            [
                'name' => PermissionEnum::VIEW_USER->value,
                'title' => PermissionEnum::VIEW_USER->title(),
                'guard_name' => 'web',
            ],
            [
                'name' => PermissionEnum::CREATE_USER->value,
                'title' => PermissionEnum::CREATE_USER->title(),
                'guard_name' => 'web',
            ],
            [
                'name' => PermissionEnum::UPDATE_USER->value,
                'title' => PermissionEnum::UPDATE_USER->title(),
                'guard_name' => 'web',
            ],
            [
                'name' => PermissionEnum::DELETE_USER->value,
                'title' => PermissionEnum::DELETE_USER->title(),
                'guard_name' => 'web',
            ],
        ];
    }
}
