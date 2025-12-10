<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        if (Question::first()) {
            return;
        }
        $questionTypes = QuestionType::all();

        $questions = [
            [
                'text' => 'Які основні обов\'язки покладаються на посадових осіб щодо охорони праці?',
                'question_type_id' => $questionTypes->where('slug', 'pravylna-vidpovid')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'охорона праці посадових осіб',
                    'difficulty' => 'середній'
                ]
            ],
            [
                'text' => 'Встановіть правильну послідовність дій при виявленні несправності електрообладнання',
                'question_type_id' => $questionTypes->where('slug', 'vybir-poslidovnosti')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'електробезпека',
                    'difficulty' => 'просунутий'
                ]
            ],
            [
                'text' => 'Які засоби індивідуального захисту обов\'язкові при роботі з посудинами під тиском?',
                'question_type_id' => $questionTypes->where('slug', 'mnozhinnyj-vybir')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'обладнання під тиском',
                    'difficulty' => 'середній'
                ]
            ],
            [
                'text' => 'Чи дозволено використовувати несправний навантажувач?',
                'question_type_id' => $questionTypes->where('slug', 'tak-ni')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'вантажопідіймальне обладнання',
                    'difficulty' => 'легкий'
                ]
            ],
            [
                'text' => 'Встановіть відповідність між видом крана та його вантажопідіймальністю',
                'question_type_id' => $questionTypes->where('slug', 'vidpovidnist')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'вантажопідіймальне обладнання',
                    'difficulty' => 'просунутий'
                ]
            ],
            [
                'text' => 'Які основні правила безпеки при виконанні зварювальних робіт?',
                'question_type_id' => $questionTypes->where('slug', 'pravylna-vidpovid')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'зварювальні роботи',
                    'difficulty' => 'середній'
                ]
            ],
            [
                'text' => 'Вставити пропущене слово: При роботах на висоті обов\'язкове використання ___________',
                'question_type_id' => $questionTypes->where('slug', 'vstavyty-propushene-slovo')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'роботи на висоті',
                    'difficulty' => 'легкий'
                ]
            ],
            [
                'text' => 'Чи потребує ліфт технічний огляд перед введенням в експлуатацію?',
                'question_type_id' => $questionTypes->where('slug', 'tak-ni')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'ліфтове господарство',
                    'difficulty' => 'легкий'
                ]
            ],
            [
                'text' => 'Які документи необхідні для безпечної експлуатації посудин під тиском?',
                'question_type_id' => $questionTypes->where('slug', 'mnozhinnyj-vybir')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'обладнання під тиском',
                    'difficulty' => 'середній'
                ]
            ],
            [
                'text' => 'Встановіть правильну послідовність евакуації при виникненні аварійної ситуації',
                'question_type_id' => $questionTypes->where('slug', 'vybir-poslidovnosti')->first()->id ?? $questionTypes->first()->id,
                'score' => 1,
                'metadata' => [
                    'category' => 'загальні вимоги',
                    'difficulty' => 'середній'
                ]
            ],
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }
    }
}
