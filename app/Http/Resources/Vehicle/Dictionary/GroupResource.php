<?php

namespace App\Http\Resources\Vehicle\Dictionary;

use App\Http\Resources\Vehicle\VehicleCollection;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /** @var Group */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'is_default' => $this->resource->is_default,
            'vehicles' => VehicleCollection::make($this->whenLoaded('vehicles')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
