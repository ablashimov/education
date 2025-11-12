<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VehicleIconResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'path' => $this->resource,
            'image' => base64_encode(Storage::disk(config('filesystems.default'))->get($this->resource)),
        ];
    }
}
