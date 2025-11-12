<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getOrganizationStatuses() as $organizationStatus) {
            Status::query()
                ->updateOrCreate(
                    attributes: ['slug' => $organizationStatus['slug']],
                    values: $organizationStatus
                );
        }
    }

    private function getOrganizationStatuses(): array
    {
        return [
            [
                'name' => StatusEnum:: VERIFICATION->title(),
                'slug' => StatusEnum:: VERIFICATION,
            ],
            [
                'name' => StatusEnum::ACTIVE->title(),
                'slug' => StatusEnum::ACTIVE,
            ],
            [
                'name' => StatusEnum::INACTIVE->title(),
                'slug' => StatusEnum::INACTIVE,
            ],
        ];
    }
}
