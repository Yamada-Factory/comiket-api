<?php

namespace App\Http\Responses\Api\V1\Circle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleCollection extends JsonResource
{
    public function toArray($request): array
    {
        return CircleResource::collection($this->resource)->toArray($request);
    }
}
