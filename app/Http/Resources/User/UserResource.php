<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Vehicle\Device\DeviceResource;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @var User */
    public $resource;

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'rank' => $this->resource->rank,
            'status_id' => $this->resource->status_id,
            'email_verified_at' => $this->resource->email_verified_at,
            'last_login_at' => $this->resource->last_login_at,
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
            'roles' => OnlyRoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];

//        if ($this->resource->relationLoaded('permissions')) {
//            $data['permissions'] = PermissionResource::collection($this->resource->getAllPermissions());
//        }

        return $data;
    }
}
