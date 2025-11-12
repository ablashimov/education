<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\AttemptRepositoryInterface;
use App\Models\ExamAttempt;
use Illuminate\Database\Eloquent\Model;

readonly class AttemptRepository extends AbstractRepository implements AttemptRepositoryInterface
{
    public function getModel(): Model
    {
        return new ExamAttempt();
    }
}
