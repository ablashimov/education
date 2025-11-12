<?php

namespace App\Http\Resources\Vehicle\Device\Data;

use App\Models\IOData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IODataResource extends JsonResource
{
    /**
     * @var IOData $resource
     */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'id' => $this->resource->id,
            'data' => null,
//            'data' => $this->resource->data,
            'sent_at' => $this->resource->sent_at,
            'created_at' => $this->resource->created_at
        ];

//        return $data;
        $ioData = $this->resource->data;

        if (! empty($ioData)) {
            foreach ($ioData as $key => $item) {
                $ioData[$key]['id'] = (string)$item['id'];
            }

            $data['data'] = $ioData;
        }

        return $data;
    }
}
