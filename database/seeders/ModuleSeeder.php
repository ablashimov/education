<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        if (Module::first()){
            return;
        }
        $course = Course::limit(2)->get();
        $first = $course->first();

        $modules = [
            [
                'course_id' => $first->id,
                'title' => 'Загальний курс',
                'order' => 1,
                'settings' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
            [
                'course_id' => $first->id,
                'title' => 'Електробезпека',
                'order' => 2,
                'settings' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
            [
                'course_id' => $first->id,
                'title' => 'Гігієна',
                'order' => 3,
                'settings' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
            [
                'course_id' => $first->id,
                'title' => 'Перша допомога',
                'order' => 4,
                'settings' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
            [
                'course_id' => $course->last()->id,
                'title' => 'Перша допомога',
                'order' => 4,
                'settings' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate($module);
        }
    }
}
