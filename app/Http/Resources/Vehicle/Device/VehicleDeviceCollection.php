<?php

namespace App\Http\Resources\Vehicle\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleDeviceCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return VehicleDeviceResource::collection($this->collection);
    }
}
