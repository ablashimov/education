<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::limit(2)->get();
        $modules = Module::all();
        $questions = Question::all();

        $exams = [
            [
                'title' => 'Тест з охорони праці посадових осіб',
                'description' => 'Підсумковий тест з охорони праці для керівників',
                'attempts_allowed' => 3,
                'time_limit' => 60, // хвилини
                'config' => [
                    'passing_score' => 70,
                    'show_results' => true,
                    'randomize_questions' => true
                ]
            ],
            [
                'title' => 'Екзамен з електробезпеки',
                'description' => 'Тестування знань правил безпечної експлуатації електроустановок',
                'attempts_allowed' => 2,
                'time_limit' => 45,
                'config' => [
                    'passing_score' => 80,
                    'show_results' => true,
                    'randomize_questions' => false
                ]
            ],
        ];

        foreach ($exams as $index => $examData) {
            $course = $courses[$index % $courses->count()];
            $module = $modules->where('course_id', $course->id)->first();

            $exam = Exam::create([
                'course_id' => $course->id,
                'module_id' => $module->id ?? null,
                'title' => $examData['title'],
                'description' => $examData['description'],
                'attempts_allowed' => $examData['attempts_allowed'],
                'time_limit' => $examData['time_limit'],
                'config' => $examData['config'],
            ]);

            // Прив'язати випадкові питання до екзамену
            $examQuestions = $questions->random(min(5, $questions->count()));
            foreach ($examQuestions as $question) {
                $exam->questions()->attach($question->id);
            }
        }
    }
}
