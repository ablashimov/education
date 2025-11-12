<?php

namespace App\Http\Resources\Vehicle\Device;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * @var Device $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request): array
    {
        $activeVehicle = $this->resource->relationLoaded('activeVehicle');
        $data = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'imei' => $this->resource->imei,
            'phone' => $this->resource->phone,
            'is_active' => $this->resource->is_active,
            'model' => DeviceModelResource::make($this->whenLoaded('deviceModel')),
            'sensors' => DeviceSensorCollection::make($this->whenLoaded('deviceSensors')),
            'users' => UserCollection::make($this->whenLoaded('users')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];

        if ($activeVehicle && $this->resource->activeVehicle->first()) {
            $data['vehicle'] = VehicleResource::make($this->resource->activeVehicle->first());
            $data['is_default'] = $this->resource->activeVehicle->first()->pivot->is_default;
        }

        return $data;
    }
}
