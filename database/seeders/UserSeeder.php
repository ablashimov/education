<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::first();
        $statuses = Status::whereIn('slug', [StatusEnum::ACTIVE, StatusEnum::INACTIVE, StatusEnum::VERIFICATION])
            ->get();
        $users = [
            [
                'organization_id' => $organization?->id,
                'email' => 'alice.learner@example.org',
                'password' => Hash::make('password123'),
                'name' => 'Alice Learner',
                'rank' => 'soldier',
                'status_id' => $statuses->where('slug', StatusEnum::ACTIVE)->first()->id,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'roles' => [
                    RoleEnum::USER,
                ],
            ],
            [
                'organization_id' => $organization?->id,
                'email' => 'ivan.instructor@example.org',
                'password' => Hash::make('password123'),
                'name' => 'Ivan Instructor',
                'rank' => 'soldier',
                'status_id' => $statuses->where('slug', StatusEnum::VERIFICATION)->first()->id,
                'roles' => [
                    RoleEnum::MANAGER,
                ],
            ],
            [
                'organization_id' => $organization?->id,
                'email' => 'admin@example.org',
                'password' => Hash::make('password123'),
                'name' => 'Admin User',
                'rank' => 'soldier',
                'status_id' => $statuses->where('slug', StatusEnum::INACTIVE)->first()->id,
                'roles' => [
                    RoleEnum::ADMIN,
                ],
            ],
        ];

        foreach ($users as $user) {
            if (! User::query()->where('email', $user['email'])->exists()) {
                $createdUser = User::query()->create(\Arr::except($user, 'roles'));
                $createdUser->syncRoles($user['roles']);
            }
        }
    }
}
