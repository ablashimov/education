<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use App\Models\VehicleSession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleSessionResource extends JsonResource
{
    /**
     * @var VehicleSession $resource
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'vehicle_device_id' => $this->resource->vehicle_device_id,
            'termination_reason' => $this->resource->termination_reason,
            'started_at' => $this->resource->started_at,
            'ended_at' => $this->resource->ended_at,
            'track' => TrackResource::make($this->whenLoaded('track')),
        ];
    }
}
