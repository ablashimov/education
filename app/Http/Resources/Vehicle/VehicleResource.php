<?php

namespace App\Http\Resources\Vehicle;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Vehicle\Device\VehicleDeviceCollection;
use App\Http\Resources\Vehicle\Dictionary\GroupResource;
use App\Http\Resources\Vehicle\Dictionary\VehicleStatusResource;
use App\Http\Resources\Vehicle\Dictionary\VehicleTypeResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Quartsoft\File\Http\Resources\FileResource;

class VehicleResource extends JsonResource
{
    /**
     * @var Vehicle $resource
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'vin' => $this->resource->vin,
            'state_number' => $this->resource->state_number,
            'brand' => $this->resource->brand,
            'model' => $this->resource->model,
            'year' => $this->resource->year,
            'notes' => $this->resource->notes,
            'type' => VehicleTypeResource::make($this->whenLoaded('type')),
            'status' => VehicleStatusResource::make($this->whenLoaded('status')),
            'vehicle_devices' => VehicleDeviceCollection::make($this->whenLoaded('vehicleDevices')),
            'users' => UserCollection::make($this->whenLoaded('users')),
            'group' => GroupResource::make($this->whenLoaded('group')),
            'image' => FileResource::make($this->whenLoaded('image')),
            'icon' => $this->resource->relationLoaded('icon')
                ? base64_encode(Storage::disk('public')->get($this->resource->icon->path))
                : null,
//            'icon' => FileResource::make($this->whenLoaded('icon')),
            'track_color' => $this->resource->track_color,
            'is_active' => $this->resource->is_active,
            'sensors' => VehicleSensorCollection::make($this->whenLoaded('vehicleSensors')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
