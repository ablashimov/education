<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        if (Group::first()){
            return;
        }
        $courses = Course::all();

        $groups = [
            [
                'name' => 'ОП-2024-01',
                'description' => 'Група з охорони праці для керівників',
                'start_date' => now()->addDays(1),
                'end_date' => now()->addMonths(2),
            ],
            [
                'name' => 'ОП-2024-02',
                'description' => 'Група з охорони праці для робітників',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addMonths(2)->addDays(7),
            ],
            [
                'name' => 'ОП-2024-03',
                'description' => 'Група з охорони праці для інженерів',
                'start_date' => now()->addDays(14),
                'end_date' => now()->addMonths(2)->addDays(14),
            ],
            [
                'name' => 'Електробезпека-2024-01',
                'description' => 'Група з правил електробезпеки',
                'start_date' => now()->addDays(3),
                'end_date' => now()->addMonths(1)->addDays(17),
            ],
            [
                'name' => 'Висотні роботи-2024-01',
                'description' => 'Група з безпеки робіт на висоті',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addMonths(1)->addDays(24),
            ],
        ];

        foreach ($courses as $index => $course) {
            $groupData = $groups[$index % count($groups)];
            Group::create([
                'course_id' => $course->id,
                'name' => $groupData['name'],
                'description' => $groupData['description'],
                'start_date' => $groupData['start_date'],
                'end_date' => $groupData['end_date'],
                'created_at' => now(),
            ]);
        }
    }
}
