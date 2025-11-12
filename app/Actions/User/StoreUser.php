<?php

namespace App\Actions\User;

use App\DTO\UserDTO;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Interfaces\Repositories\StatusRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

readonly class StoreUser
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private RoleRepositoryInterface $roleRepository,
        private StatusRepositoryInterface $statusRepository
    ) {
    }

    public function execute(UserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $status = $this->statusRepository->findBy([
                'slug' => StatusEnum::VERIFICATION->value
            ]);
            $data = $dto->toArray();
            $data['status_id'] = $status->id;
            /** @var User $user */
            $user = $this->repository->create($data);
            $role = $this->roleRepository->findBy([
                'name' => RoleEnum::USER->value
            ]);
            $user->syncRoles($role);

            return $user->load(['roles']);
        });
    }
}
