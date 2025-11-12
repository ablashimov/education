<?php

namespace App\Actions\User;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

readonly class GetUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(int $id): User
    {
        return $this->repository->getById($id, ['roles']);
    }
}
