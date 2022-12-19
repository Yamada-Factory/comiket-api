<?php

namespace App\Http\Responses\Api\V1\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventCollection extends JsonResource
{
    public function toArray($request): array
    {
        return EventResource::collection($this->resource)->toArray($request);
    }
}
