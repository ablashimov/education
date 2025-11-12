<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\StatusRepositoryInterface;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

readonly class StatusRepository extends AbstractRepository implements StatusRepositoryInterface
{
    public function getModel(): Model
    {
        return new Status();
    }
}
