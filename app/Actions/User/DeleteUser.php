<?php

namespace App\Actions\User;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

readonly class DeleteUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->repository->deleteModel($user);
        });
    }
}
