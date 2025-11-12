<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use App\Models\SessionData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionDataResource extends JsonResource
{
    /**
     * @var SessionData $resource
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
            'point' => $this->resource->point,
            'parsed_point' => $this->resource->parsed_point,
            'event_id' => $this->resource->event_id,
            'priority' => $this->resource->priority,
            'codec_id' => $this->resource->codec_id,
            'angle' => $this->resource->angle,
            'speed' => $this->resource->speed,
            'satellites' => $this->resource->satellites,
            'sent_at' => $this->resource->sent_at,
            'io_data' => IODataResource::make($this->whenLoaded('ioData')),
            'created_at' => $this->resource->created_at
        ];
    }
}
