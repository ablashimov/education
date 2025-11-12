<?php

namespace App\Actions\User;

use App\DTO\UserDTO;
use App\Enums\StatusEnum;
use App\Interfaces\Repositories\StatusRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

readonly class UpdateUser
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private StatusRepositoryInterface $statusRepository
    ) {
    }

    public function execute(UserDTO $dto, User $user): User
    {
        return DB::transaction(function () use ($dto, $user) {
            $data = $dto->toArray();
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $status = $this->statusRepository->findBy([
                'slug' => StatusEnum::VERIFICATION->value,
            ]);
            $data['status_id'] = $status->id;

            $this->repository->updateModel($user, $data);

            return $user->load(['roles', 'permissions']);
        });
    }
}
