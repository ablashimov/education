<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            OrganizationSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            ModuleSeeder::class,
            QuestionTypeSeeder::class,
            QuestionSeeder::class,
            ExamSeeder::class,
            GroupSeeder::class,
            ExamResultStatusSeeder::class,
        ]);
    }
}
