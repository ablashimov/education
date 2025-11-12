<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleSensorCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return VehicleSensorResource::collection($this->collection);
    }
}
