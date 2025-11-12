<?php

namespace App\Http\Resources\Vehicle\Device;

use App\Http\Resources\Vehicle\Device\Data\SessionDataResource;
use App\Models\VehicleDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleDeviceResource extends JsonResource
{
    /**
     * @var VehicleDevice $resource
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
            'vehicle_id' => $this->resource->vehicle_id,
            'device_id' => $this->resource->device_id,
            'is_default' => $this->resource->is_default,
            'device' => DeviceResource::make($this->whenLoaded('device')),
            'last_data' => SessionDataResource::make($this->whenLoaded('lastData'))
        ];
    }
}
