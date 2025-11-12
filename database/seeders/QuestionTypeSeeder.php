<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $questionTypes = [
            [
                'name' => QuestionTypeEnum::MNOZHINNYJ_VYBIR->title(),
                'slug' => QuestionTypeEnum::MNOZHINNYJ_VYBIR->value,
            ],
            [
                'name' => QuestionTypeEnum::ODINOKIJ_VYBIR->title(),
                'slug' => QuestionTypeEnum::ODINOKIJ_VYBIR->value,
            ],
            [
                'name' => QuestionTypeEnum::NAPISATI_VIDPOVID->title(),
                'slug' => QuestionTypeEnum::NAPISATI_VIDPOVID->value,
            ],
            [
                'name' => QuestionTypeEnum::VYBIR_POSLIDOVNOSTI->title(),
                'slug' => QuestionTypeEnum::VYBIR_POSLIDOVNOSTI->value,
            ]
        ];

        foreach ($questionTypes as $type) {
            QuestionType::query()->firstOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}
