<?php

namespace App\Http\Resources\Vehicle\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeviceCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return DeviceResource::collection($this->collection);
    }
}
