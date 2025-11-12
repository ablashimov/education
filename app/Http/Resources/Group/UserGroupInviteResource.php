<?php

namespace App\Http\Resources\Group;

use App\Http\Resources\User\UserResource;
use App\Models\UserGroupInvite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGroupInviteResource extends JsonResource
{
    /** @var UserGroupInvite */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'invited_at' => $this->resource->invited_at,
            'accepted_at' => $this->resource->accepted_at,
        ];
    }
}
