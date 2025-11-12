<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\Status;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = Status::whereIn('slug', [StatusEnum::ACTIVE, StatusEnum::INACTIVE, StatusEnum::VERIFICATION])->get();
        $organizations = [
            [
                'name' => 'Центр охорони праці України',
                'slug' => 'centr-ohorony-praci',
                'settings' => [
                    'description' => 'Державний центр з охорони праці та промислової безпеки',
                    'address' => 'Київ, вул. Хрещатик, 1',
                    'phone' => '+380441234567',
                    'email' => 'info@ohoronapraci.gov.ua',
                    'type' => 'державна установа',
                ],
                'status_id' => $statuses->where('slug', StatusEnum::ACTIVE)->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Навчальний центр "Безпека праці"',
                'slug' => 'navchalnyj-centr-bezpeka',
                'settings' => [
                    'description' => 'Приватний навчальний центр з охорони праці',
                    'address' => 'Київ, вул. Шота Руставелі, 15',
                    'phone' => '+380442223334',
                    'email' => 'info@bezpekapraci.ua',
                    'type' => 'приватний центр',
                ],
                'status_id' => $statuses->where('slug', StatusEnum::VERIFICATION)->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Інститут промислової безпеки',
                'slug' => 'institut-promyslovoi-bezpeky',
                'settings' => [
                    'description' => 'Науково-дослідний інститут з питань промислової безпеки',
                    'address' => 'Харків, вул. Сумська, 45',
                    'phone' => '+380577788899',
                    'email' => 'info@industrial-safety.gov.ua',
                    'type' => 'науково-дослідний інститут',
                ],
                'status_id' => $statuses->where('slug', StatusEnum::INACTIVE)->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($organizations as $organization) {
            Organization::query()->firstOrCreate(
                ['slug' => $organization['slug']],
                $organization
            );
        }
    }
}
