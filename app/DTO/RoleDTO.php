<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Http\Request;

final readonly class RoleDTO
{
    public function __construct(
        public string $name,
        public string $title,
        public int $organizationId,
        public array $settings,
        public array $permissions = [],
        public string $guard = 'sanctum',
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            title: $request->get('title'),
            organizationId: auth()->user()->organization_id,
            settings: $request->get('settings'),
            permissions: $request->get('permissions'),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'organization_id' => $this->organizationId,
            'guard_name' => $this->guard,
            'settings' => $this->settings
        ];
    }
}
