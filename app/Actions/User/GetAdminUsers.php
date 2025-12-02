<?php

namespace App\Actions\User;

use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetAdminUsers
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(): Collection
    {
        return $this->repository->getAdmins();
    }
}
