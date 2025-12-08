<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Питання',
                'slug' => 'questions',
                'description' => 'Задайте питання та отримайте відповідь',
                'color' => 'bg-blue-100 text-blue-700',
                'order' => 1,
            ],
            [
                'name' => 'Обговорення',
                'slug' => 'discussions',
                'description' => 'Обговоріть тему з колегами',
                'color' => 'bg-purple-100 text-purple-700',
                'order' => 2,
            ],
            [
                'name' => 'Технічна підтримка',
                'slug' => 'support',
                'description' => 'Повідомте про проблему або баг',
                'color' => 'bg-orange-100 text-orange-700',
                'order' => 3,
            ],
            [
                'name' => 'Оголошення',
                'slug' => 'announcements',
                'description' => 'Важливі оголошення від адміністрації',
                'color' => 'bg-green-100 text-green-700',
                'order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            ForumCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
