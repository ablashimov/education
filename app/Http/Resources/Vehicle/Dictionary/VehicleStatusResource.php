<?php

namespace App\Http\Resources\Vehicle\Dictionary;

use App\Models\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleStatusResource extends JsonResource
{
    /**
     * @var VehicleStatus $resource
     */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'color' => $this->resource->color,
            'created_at' => $this->resource->created_at,
        ];
    }
}
