<?php

namespace App\Http\Resources\Vehicle\Device;

use App\Http\Resources\Vehicle\VehicleSensorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeviceSensorCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return DeviceSensorResource::collection($this->collection);
    }
}
