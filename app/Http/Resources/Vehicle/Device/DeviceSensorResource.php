<?php

namespace App\Http\Resources\Vehicle\Device;

use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\Group\SensorUnitResource;
use App\Models\DeviceSensor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceSensorResource extends JsonResource
{
    /** @var DeviceSensor */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'coefficient' => $this->resource->coefficient,
            'sensor' => GroupResource::make($this->whenLoaded('sensor')),
            'sensor_unit' => SensorUnitResource::make($this->whenLoaded('deviceSensorUnit')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
