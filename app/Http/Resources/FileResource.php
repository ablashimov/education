<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /** @var File */
    public $resource;

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'path' => $this->resource->path,
            'path_url' => $this->resource->path_url,
            'name' => $this->resource->name,
            'size' => $this->resource->size,
            'mimetype' => $this->resource->mime_type,
            'description' => $this->resource->description,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
