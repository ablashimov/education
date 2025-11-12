<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\AnswerRepositoryInterface;
use App\Models\ExamAnswer;
use Illuminate\Database\Eloquent\Model;

readonly class AnswerRepository extends AbstractRepository implements AnswerRepositoryInterface
{
    public function getModel(): Model
    {
        return new ExamAnswer();
    }
}
