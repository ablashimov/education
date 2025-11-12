<?php

namespace App\Actions\User\Token;

use App\Interfaces\Repositories\TokenRepositoryInterface;
use App\Models\User;

readonly class DeleteUserToken
{
    public function __construct(private TokenRepositoryInterface $repository)
    {
    }

    public function execute(int $id, int $userId): void
    {
        $token = $this->repository->findBy([
            'id' => $id,
            'tokenable_id' => $userId,
            'tokenable_type' => User::class,
        ]);
        $this->repository->deleteModel($token);
    }
}
