<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * @var Track $track
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'path' => $this->resource->parsed_path,
            'distance' => $this->resource->distance,
        ];
    }
}
