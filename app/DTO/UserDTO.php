<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Http\Request;

final readonly class UserDTO
{
    public function __construct(
        public string $email,
        public string $name,
        public int $organizationId,
        public string $rank,
        public ?string $password = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->get('email'),
            name: $request->get('name'),
            organizationId: $request->input('organization_id'),
            rank: $request->get('rank'),
            password: $request->get('password'),
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
            'rank' => $this->rank,
            'organization_id' => $this->organizationId,
        ];
    }
}
