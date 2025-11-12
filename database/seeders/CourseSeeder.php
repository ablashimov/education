<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Охорона праці посадових осіб (НПАОП 0.00-4.12-05)',
                'slug' => 'ohorona-praci-posadovyh-osib',
                'is_available' => true,
                'settings' => [
                    'description' => 'Навчання з охорони праці для керівників та посадових осіб',
                    'duration' => '40 годин',
                    'category' => 'загальні вимоги',
                    'document_code' => 'НПАОП 0.00-4.12-05',
                ],
            ],
            [
                'title' => 'Правила безпечної експлуатації електроустановок споживачів (НПАОП 40.1-1.21-98)',
                'slug' => 'elektrobezpeka-spozhyvachiv',
                'is_available' => true,
                'settings' => [
                    'description' => 'Правила безпеки при експлуатації електричних установок',
                    'duration' => '36 годин',
                    'category' => 'електробезпека',
                    'document_code' => 'НПАОП 40.1-1.21-98',
                ],
            ],
            [
                'title' => 'Організація безпечної експлуатації посудин під тиском (НПАОП 0.00-1.81-18)',
                'slug' => 'posudyny-pid-tyskom',
                'is_available' => true,
                'settings' => [
                    'description' => 'Вимоги до безпечної експлуатації посудин, що працюють під тиском',
                    'duration' => '24 години',
                    'category' => 'обладнання під тиском',
                    'document_code' => 'НПАОП 0.00-1.81-18',
                ],
            ],
            [
                'title' => 'Правила ОП під час експлуатації навантажувачів (НПАОП 0.00-1.83-18)',
                'slug' => 'navantazhuvachi',
                'is_available' => true,
                'settings' => [
                    'description' => 'Охорона праці при роботі з навантажувачами',
                    'duration' => '32 години',
                    'category' => 'вантажопідіймальне обладнання',
                    'document_code' => 'НПАОП 0.00-1.83-18',
                ],
            ],
            [
                'title' => 'Правила охорони праці під час експлуатації вантажопідіймальних кранів, підіймальних пристроїв і відповідного обладнання (НПАОП 0.00-1.80-18)',
                'slug' => 'krany-vantazhopidiymalni',
                'is_available' => true,
                'settings' => [
                    'description' => 'Безпека праці з вантажопідіймальними кранами та обладнанням',
                    'duration' => '40 годин',
                    'category' => 'вантажопідіймальне обладнання',
                    'document_code' => 'НПАОП 0.00-1.80-18',
                ],
            ],
            [
                'title' => 'Правила ОП під час зварювання металів (НПАОП 28.52-1.31-13)',
                'slug' => 'zvaryuvannya-metaliv',
                'is_available' => true,
                'settings' => [
                    'description' => 'Охорона праці при виконанні зварювальних робіт',
                    'duration' => '28 годин',
                    'category' => 'зварювальні роботи',
                    'document_code' => 'НПАОП 28.52-1.31-13',
                ],
            ],
            [
                'title' => 'Правила ОП під час виконання робіт на висоті (НПАОП 0.00-1.15-07)',
                'slug' => 'robota-na-vysoti',
                'is_available' => true,
                'settings' => [
                    'description' => 'Безпека праці при виконанні робіт на висоті',
                    'duration' => '36 годин',
                    'category' => 'роботи на висоті',
                    'document_code' => 'НПАОП 0.00-1.15-07',
                ],
            ],
            [
                'title' => 'Правила будови і безпечної експлуатації ліфтів (НПАОП 0.00-1.02-08)',
                'slug' => 'liftove-gospodarstvo',
                'is_available' => true,
                'settings' => [
                    'description' => 'Вимоги до безпечної експлуатації ліфтів',
                    'duration' => '24 години',
                    'category' => 'ліфтове господарство',
                    'document_code' => 'НПАОП 0.00-1.02-08',
                ],
            ],
            [
                'title' => 'Правила безпеки при виробництві та споживанні продуктів розділення повітря (НПАОП 0.00-1.65-88)',
                'slug' => 'produkty-rozdilennia-povitria',
                'is_available' => true,
                'settings' => [
                    'description' => 'Безпека при роботі з продуктами розділення повітря',
                    'duration' => '20 годин',
                    'category' => 'газове господарство',
                    'document_code' => 'НПАОП 0.00-1.65-88',
                ],
            ],
            [
                'title' => 'Правила охорони праці під час вантажно-розвантажувальних робіт (НПАОП 0.00-1.75-15)',
                'slug' => 'vantazhno-rozvantazhuvalni-robity',
                'is_available' => true,
                'settings' => [
                    'description' => 'Охорона праці при вантажно-розвантажувальних роботах',
                    'duration' => '32 години',
                    'category' => 'вантажні роботи',
                    'document_code' => 'НПАОП 0.00-1.75-15',
                ],
            ],
            [
                'title' => 'Правила ОП під час роботи з інструментом та пристроями (НПАОП 0.00-1.71-13)',
                'slug' => 'instrument-ta-prystroi',
                'is_available' => true,
                'settings' => [
                    'description' => 'Безпека праці з ручним інструментом та пристроями',
                    'duration' => '24 години',
                    'category' => 'інструмент',
                    'document_code' => 'НПАОП 0.00-1.71-13',
                ],
            ],
            [
                'title' => 'Правила ОП на автомобільному транспорті (НПАОП 0.00-1.62-12)',
                'slug' => 'avtomobilnyj-transport',
                'is_available' => true,
                'settings' => [
                    'description' => 'Охорона праці на автомобільному транспорті',
                    'duration' => '36 годин',
                    'category' => 'автотранспорт',
                    'document_code' => 'НПАОП 0.00-1.62-12',
                ],
            ],
            [
                'title' => 'Вимоги з ОП під час виконання будівельно-монтажних робіт (НПАОП 45.2-7.02-12)',
                'slug' => 'budivelno-montazhni-robity',
                'is_available' => true,
                'settings' => [
                    'description' => 'Охорона праці при будівельно-монтажних роботах',
                    'duration' => '40 годин',
                    'category' => 'будівництво',
                    'document_code' => 'НПАОП 45.2-7.02-12',
                ],
            ],
            [
                'title' => 'Правила безпеки систем газопостачання (НПАОП 0.00-1.76-15)',
                'slug' => 'systemy-gazopostachannya',
                'is_available' => true,
                'settings' => [
                    'description' => 'Безпека систем газопостачання',
                    'duration' => '32 години',
                    'category' => 'газове господарство',
                    'document_code' => 'НПАОП 0.00-1.76-15',
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            Course::query()->firstOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );
        }
    }
}
