<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\PaginateRequest;

final readonly class PaginateDTO
{
    public const int PAGE = 1;

    public const int PER_PAGE = 20;

    final public function __construct(
        public int $page,
        public int $perPage,
        public int $userId,
        public int $organizationId,
    ) {}

    public static function fromRequest(PaginateRequest $request): PaginateDTO
    {
        return new self(
            page: (int) $request->get('page', self::PAGE),
            perPage: (int) $request->get('per_page', self::PER_PAGE),
            userId: $request->input('user_id'),
            organizationId: $request->input('organization_id'),
        );
    }
}
