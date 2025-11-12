<?php

namespace App\Http\Resources\Vehicle;

use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\Group\SensorUnitResource;
use App\Models\VehicleSensor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleSensorResource extends JsonResource
{
    /** @var VehicleSensor */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'coefficient' => $this->resource->coefficient,
            'vehicle_id' => $this->resource->vehicle_id,
            'sensor' => GroupResource::make($this->whenLoaded('sensor')),
            'sensor_unit' => SensorUnitResource::make($this->whenLoaded('vehicleSensorUnit')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
