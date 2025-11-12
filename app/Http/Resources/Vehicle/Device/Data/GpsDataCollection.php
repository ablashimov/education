<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GpsDataCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return SessionDataResource::collection($this->collection);
    }
}
