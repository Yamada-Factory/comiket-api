<?php

namespace App\Http\Responses\Api\V1\Event;

use App\Traits\ResponseFormatTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    use ResponseFormatTrait;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => [
                'facility' => $this->location_facility,
                'address' => $this->location_address,
                'longitude' => $this->location_longitude,
                'latitude' => $this->location_latitude,
                'googlemap' => $this->location_googlemap,
            ],
            'date' => [
                'from' => $this->formatDateTime($this->from_at),
                'to' => $this->formatDateTime($this->to_at),
            ],
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
        ];
    }
}
