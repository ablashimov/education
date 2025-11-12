<?php

namespace App\Http\Resources\Vehicle;

use App\Http\Resources\Group\UserGroupInviteResource;
use App\Models\Group;
use App\Models\Sensor;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /** @var Unit */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'unit_group' => UserGroupInviteResource::make($this->whenLoaded('unitGroup')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
