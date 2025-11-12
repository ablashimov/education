<?php

declare(strict_types=1);

namespace App\Interfaces;

interface FilteringInterface
{
    public function getAllowedFilters(): array;
    public function getAllowedSorts(): array;
}
