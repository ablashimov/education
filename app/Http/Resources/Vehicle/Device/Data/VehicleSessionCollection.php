<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleSessionCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => VehicleSessionResource::collection($this->collection),
            'total_distance' => round($this->collection->sum('track.distance'), 4),
        ];
    }
}
