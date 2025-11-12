<?php

namespace App\Actions\User\Token;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\TokenRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateUserTokens
{
    public function __construct(private TokenRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto, int $userId): LengthAwarePaginator
    {
        return $this->repository->paginate($dto, $userId);
    }
}
